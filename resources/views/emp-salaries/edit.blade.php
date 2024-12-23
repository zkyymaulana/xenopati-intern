@extends('layouts.app')

@section('content')
    <h1>Edit Employee Salary</h1>
    <form action="{{ route('emp-salaries.update', $empSalary->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="employee_id">Employee</label>
            <select name="employee_id" class="form-control" required>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $empSalary->employee_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="month">Month</label>
            <select name="month" class="form-control" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $empSalary->month == $i ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <select name="year" class="form-control" required>
                @for ($i = 2000; $i <= date('Y'); $i++)
                    <option value="{{ $i }}" {{ $empSalary->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="basic_salary">Basic Salary</label>
            <input type="text" name="basic_salary" class="form-control" value="{{ $empSalary->basic_salary }}" placeholder="e.g. 5000000" required>
        </div>
        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="text" name="bonus" class="form-control" value="{{ $empSalary->bonus }}" placeholder="e.g. 1000000">
        </div>
        <div class="form-group">
            <label for="bpjs">BPJS</label>
            <input type="text" name="bpjs" class="form-control" value="{{ $empSalary->bpjs }}" placeholder="e.g. 50000">
        </div>
        <div class="form-group">
            <label for="jp">JP</label>
            <input type="text" name="jp" class="form-control" value="{{ $empSalary->jp }}" placeholder="e.g. 200000">
        </div>
        <div class="form-group">
            <label for="loan">Loan</label>
            <input type="text" name="loan" class="form-control" value="{{ $empSalary->loan }}" placeholder="e.g. 300000">
        </div>
        <div class="form-group">
            <label for="total_salary">Total Salary</label>
            <input type="text" name="total_salary" class="form-control" value="{{ $empSalary->total_salary }}" placeholder="e.g. 6000000" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
