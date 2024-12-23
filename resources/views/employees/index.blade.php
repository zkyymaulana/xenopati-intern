@extends('layouts.app')

@section('content')
    <h1>Employees</h1>
    <div class="mb-3 text-right"> 
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
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
                <th>No</th>
                <th>User Picture</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($employee->user_picture)
                            <img src="{{ asset('storage/' . $employee->user_picture) }}" alt="User Picture" style="width: 100px; height: 100px; ">
                        @else
                            <span>No Picture</span>
                        @endif
                    </td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
