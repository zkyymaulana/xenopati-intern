<?php

namespace App\Http\Controllers;

use App\Models\EmpPresence;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmpPresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empPresences = EmpPresence::with('employee')->get();
        return view('emp-presences.index', compact('empPresences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('emp-presences.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date',
            'late_in' => 'nullable|integer',
            'early_out' => 'nullable|integer',
        ]);

        EmpPresence::create($validated);
        return redirect()->route('emp-presences.index')->with('success', 'Presence recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empPresence = EmpPresence::findOrFail($id);
        $employees = Employee::all();
        return view('emp-presences.edit', compact('empPresence', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empPresence = EmpPresence::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date',
            'late_in' => 'nullable|integer',
            'early_out' => 'nullable|integer',
        ]);

        $empPresence->update($validated);
        return redirect()->route('emp-presences.index')->with('success', 'Presence updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empPresence = EmpPresence::findOrFail($id);
        $empPresence->delete();
        return redirect()->route('emp-presences.index')->with('success', 'Presence deleted successfully.');
    }

    public function calculate(Request $request)
{
    $month = $request->month;
    $year = $request->year;

    // Ambil semua data pegawai
    $employees = Employee::all();

    $data = $employees->map(function ($employee) use ($month, $year) {
        // Ambil presensi berdasarkan bulan dan tahun
        $presences = EmpPresence::where('employee_id', $employee->id)
            ->whereMonth('check_in', $month)
            ->whereYear('check_in', $year)
            ->get();

        $total_bonus = 0;

        // Hitung bonus dan denda berdasarkan presensi
        foreach ($presences as $presence) {
            $late_seconds = $presence->late_in; // Keterlambatan dalam detik
            $early_out_seconds = $presence->early_out; // Pulang cepat dalam detik

            if ($late_seconds > 5 * 60) { // Jika terlambat lebih dari 5 menit
                $total_bonus -= ceil(($late_seconds - (5 * 60)) / 60) * 5000; // Denda per menit
            }

            if ($early_out_seconds > 0) { // Jika pulang lebih cepat
                $total_bonus -= ceil($early_out_seconds / 60) * 5000; // Denda per menit
            }
        }

        // Ambil komponen gaji
        $basic_salary = $employee->salaries()
            ->where('month', $month)
            ->where('year', $year)
            ->value('basic_salary');

        $loan = $employee->salaries()
            ->where('month', $month)
            ->where('year', $year)
            ->value('loan');

        // Hitung BPJS dan JP
        $bpjs = 0.02 * $basic_salary;
        $jp = 0.01 * $basic_salary;

        // Hitung total gaji
        $total_salary = ($basic_salary + $total_bonus) - ($bpjs + $jp + $loan);

        return [
            'employee' => $employee->name,
            'basic_salary' => $basic_salary,
            'bonus' => $total_bonus,
            'bpjs' => $bpjs,
            'jp' => $jp,
            'loan' => $loan,
            'total_salary' => $total_salary,
        ];
    });

    return response()->json($data);
    }
}
