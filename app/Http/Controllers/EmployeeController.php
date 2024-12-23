<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:employees,email',
            'address' => 'required|max:100',
            'phone' => 'required|max:25',
            'user_picture' => 'nullable|image|max:2048',
            'password' => 'required|min:6',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        // Simpan gambar jika ada
        if ($request->hasFile('user_picture')) {
            $validated['user_picture'] = $request->file('user_picture')->store('images', 'public');
        }

        Employee::create($validated);
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
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
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'address' => 'required|max:100',
            'phone' => 'required|max:25',
            'user_picture' => 'nullable|image|max:2048',
            'password' => 'nullable|min:6',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Simpan gambar jika ada
        if ($request->hasFile('user_picture')) {
            // Hapus gambar lama jika ada
            if ($employee->user_picture) {
                Storage::disk('public')->delete($employee->user_picture);
            }
            $validated['user_picture'] = $request->file('user_picture')->store('images', 'public');
        }

        $employee->update($validated);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
