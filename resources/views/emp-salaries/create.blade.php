@extends('layouts.app')

@section('content')
    <h1>Add Employee Salary</h1>
    <form action="{{ route('emp-salaries.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="employee_id">Employee</label>
            <select name="employee_id" class="form-control" required>
                <option value="">Select Employee</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="month">Month</label>
            <select name="month" class="form-control" required>
                <option value="">Select Month</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="year">Year</label>
            <select name="year" class="form-control" required>
                @for ($i = 2000; $i <= date('Y'); $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="basic_salary">Basic Salary</label>
            <input type="text" name="basic_salary" class="form-control" placeholder="e.g. 5000000" required>
        </div>
        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="text" name="bonus" class="form-control" placeholder="e.g. 1000000">
        </div>
        <div class="form-group">
            <label for="bpjs">BPJS</label>
            <input type="text" name="bpjs" class="form-control" placeholder="e.g. 50000">
        </div>
        <div class="form-group">
            <label for="jp">JP</label>
            <input type="text" name="jp" class="form-control" placeholder="e.g. 200000">
        </div>
        <div class="form-group">
            <label for="loan">Loan</label>
            <input type="text" name="loan" class="form-control" placeholder="e.g. 300000">
        </div>
        <div class="form-group">
            <label for="total_salary">Total Salary</label>
            <input type="text" name="total_salary" class="form-control" placeholder="e.g. 6000000" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
@endsection
