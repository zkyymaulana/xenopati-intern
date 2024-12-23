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
                <th>Employee</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Late In</th>
                <th>Early Out</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empPresences as $presence)
                <tr>
                    <td>{{ $presence->employee->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($presence->check_in)->format('Y-m-d H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($presence->check_out)->format('Y-m-d H:i') }}</td>
                    <td>{{ convertMinutesToHours($presence->late_in) }}</td>
                    <td>{{ convertMinutesToHours($presence->early_out) }}</td>
                    <td>
                        <a href="{{ route('emp-presences.edit', $presence->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('emp-presences.destroy', $presence->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this presence?');">
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

@php
function convertMinutesToHours($minutes) {
    $hours = floor($minutes / 60);
    $remainingMinutes = $minutes % 60;
    return "{$hours} h {$remainingMinutes} m";
}
@endphp
