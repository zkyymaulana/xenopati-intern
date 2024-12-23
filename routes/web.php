<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmpPresenceController;
use App\Http\Controllers\EmpSalaryController;
use App\Http\Controllers\PayrollController;

Route::resource('employees', EmployeeController::class);
Route::resource('emp-presences', EmpPresenceController::class);
Route::resource('emp-salaries', EmpSalaryController::class);
Route::match(['get', 'post'], '/payroll', [PayrollController::class, 'index'])->name('payroll.index');
