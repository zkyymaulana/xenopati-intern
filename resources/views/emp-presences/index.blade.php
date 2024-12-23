@extends('layouts.app')

@section('content')
    <h1>Employee Presences</h1>
    <div class="mb-3 text-right">
        <a href="{{ route('emp-presences.create') }}" class="btn btn-primary">Add Presence</a>
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
                <th>Check In</th>
                <th>Check Out</th>
                <th>Late In (minutes)</th>
                <th>Early Out (minutes)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empPresences as $presence)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $presence->employee->name }}</td>
                    <td>{{ $presence->check_in }}</td>
                    <td>{{ $presence->check_out }}</td>
                    <td>{{ $presence->late_in }}</td>
                    <td>{{ $presence->early_out }}</td>
                    <td>
                        <a href="{{ route('emp-presences.edit', $presence->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('emp-presences.destroy', $presence->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this presence?');">
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
