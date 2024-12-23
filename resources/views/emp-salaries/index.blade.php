@extends('layouts.app')

@section('content')
    <h1>Employee Salaries</h1>
    <div class="mb-3 text-right"> 
    <a href="{{ route('emp-salaries.create') }}" class="btn btn-primary mb-3">Add Salary</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Employee</th>
                <th>Month</th>
                <th>Year</th>
                <th>Basic Salary</th>
                <th>Bonus</th>
                <th>BPJS</th>
                <th>JP</th>
                <th>Loan</th>
                <th>Total Salary</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empSalaries as $salary)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $salary->employee->name }}</td>
                    <td>{{ date('F', mktime(0, 0, 0, $salary->month, 1)) }}</td>
                    <td>{{ $salary->year }}</td>
                    <td>{{ number_format($salary->basic_salary, 2) }}</td>
                    <td>{{ number_format($salary->bonus, 2) }}</td>
                    <td>{{ number_format($salary->bpjs, 2) }}</td>
                    <td>{{ number_format($salary->jp, 2) }}</td>
                    <td>{{ number_format($salary->loan, 2) }}</td>
                    <td>{{ number_format($salary->total_salary, 2) }}</td>
                    <td>
                        <a href="{{ route('emp-salaries.edit', $salary->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('emp-salaries.destroy', $salary->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this salary?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
