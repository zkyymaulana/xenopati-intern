<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmpSalary;
use App\Models\EmpPresence;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('payroll.index', compact('months'));
    }

    public function calculate(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        // Ambil data pegawai
        $employees = Employee::all();

        $data = $employees->map(function ($employee) use ($month, $year) {
            // Ambil presensi
            $presences = EmpPresence::where('employee_id', $employee->id)
                ->whereMonth('check_in', $month)
                ->whereYear('check_in', $year)
                ->get();

            // Hitung denda bonus (keterlambatan dan pulang cepat)
            $bonus = 0;
            foreach ($presences as $presence) {
                $bonus -= ($presence->late_in * 5000) + ($presence->early_out * 5000);
            }

            // Hitung komponen gaji
            $basic_salary = $employee->salaries()->where('month', $month)->where('year', $year)->value('basic_salary');
            $bpjs = 0.02 * $basic_salary;
            $jp = 0.01 * $basic_salary;
            $loan = $employee->salaries()->where('month', $month)->where('year', $year)->value('loan');

            // Hitung total gaji
            $total_salary = ($basic_salary + $bonus) - ($bpjs + $jp + $loan);

            return [
                'employee' => $employee->name,
                'basic_salary' => $basic_salary,
                'bonus' => $bonus,
                'bpjs' => $bpjs,
                'jp' => $jp,
                'loan' => $loan,
                'total_salary' => $total_salary,
            ];
        });

        return response()->json($data);
    }
}
