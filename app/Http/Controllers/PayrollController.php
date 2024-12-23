<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmpSalary;
use App\Models\EmpPresence;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        // Definisikan bulan untuk tampilan
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Jika permintaan adalah POST, lakukan perhitungan
        if ($request->isMethod('post')) {
            $month = $request->month;
            $year = $request->year;

            // Ambil semua pegawai
            $employees = Employee::all();
            $results = [];

            foreach ($employees as $employee) {
                // Ambil presensi untuk bulan dan tahun yang ditentukan
                $presences = EmpPresence::where('employee_id', $employee->id)
                    ->whereMonth('check_in', $month)
                    ->whereYear('check_in', $year)
                    ->get();

                $bonus = 0;
                foreach ($presences as $presence) {
                    // Hitung denda untuk terlambat
                    if ($presence->late_in > 5 * 60) { // lebih dari 5 menit
                        $bonus -= (($presence->late_in / 60) - 5) * 5000; // Denda Rp 5.000 per menit
                    }
                    // Hitung denda untuk pulang cepat
                    if ($presence->early_out < 0) { // pulang cepat
                        $bonus -= abs($presence->early_out / 60) * 5000; // Denda Rp 5.000 per menit
                    }
                }

                // Ambil gaji dasar
                $basic_salary = $employee->salaries()->where('month', $month)->where('year', $year)->value('basic_salary');
                $loan = $employee->salaries()->where('month', $month)->where('year', $year)->value('loan');

                // Hitung BPJS dan JP
                $bpjs = 0.02 * $basic_salary; // 2% dari basic salary
                $jp = 0.01 * $basic_salary; // 1% dari basic salary

                // Hitung total gaji
                $total_salary = ($basic_salary + $bonus) - ($bpjs + $jp + $loan);

                // Simpan hasil perhitungan
                $results[] = [
                    'month' => $month,
                    'year' => $year,
                    'employee' => $employee,
                    'basic_salary' => $basic_salary,
                    'bonus' => $bonus,
                    'bpjs' => $bpjs,
                    'jp' => $jp,
                    'loan' => $loan,
                    'total_salary' => $total_salary,
                ];
            }

            return view('payroll.index', compact('months', 'results'));
        }

        // Jika permintaan adalah GET, tampilkan halaman perhitungan gaji
        return view('payroll.index', compact('months'));
    }

    public function showCalculatePage()
    {
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('payroll.calculate', compact('months'));
    }
}