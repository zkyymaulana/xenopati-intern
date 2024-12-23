<?php

namespace App\Http\Controllers;

use App\Models\EmpSalary;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmpSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empSalaries = EmpSalary::with('employee')->get();
        return view('emp-salaries.index', compact('empSalaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::all();
        return view('emp-salaries.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2000',
            'basic_salary' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'bpjs' => 'nullable|numeric',
            'jp' => 'nullable|numeric',
            'loan' => 'nullable|numeric',
            'total_salary' => 'required|numeric',
        ]);

        EmpSalary::create($validated);
        return redirect()->route('emp-salaries.index')->with('success', 'Salary recorded successfully.');
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
        $empSalary = EmpSalary::findOrFail($id);
        $employees = Employee::all();
        return view('emp-salaries.edit', compact('empSalary', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $empSalary = EmpSalary::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2000',
            'basic_salary' => 'required|numeric',
            'bonus' => 'nullable|numeric',
            'bpjs' => 'nullable|numeric',
            'jp' => 'nullable|numeric',
            'loan' => 'nullable|numeric',
            'total_salary' => 'required|numeric',
        ]);

        $empSalary->update($validated);
        return redirect()->route('emp-salaries.index')->with('success', 'Salary updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empSalary = EmpSalary::findOrFail($id);
        $empSalary->delete();
        return redirect()->route('emp-salaries.index')->with('success', 'Salary deleted successfully.');
    }
}
