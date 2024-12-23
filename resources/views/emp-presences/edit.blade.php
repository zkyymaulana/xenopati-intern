@extends('layouts.app')

@section('content')
    <h1>Edit Presence</h1>
    <form action="{{ route('emp-presences.update', $empPresence->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="employee_id">Employee</label>
            <select name="employee_id" class="form-control" required>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" {{ $empPresence->employee_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="check_in">Check In</label>
            <input type="datetime-local" name="check_in" class="form-control" value="{{ $empPresence->check_in }}" required>
        </div>
        <div class="form-group">
            <label for="check_out">Check Out</label>
            <input type="datetime-local" name="check_out" class="form-control" value="{{ $empPresence->check_out }}" required>
        </div>
        <div class="form-group">
            <label for="late_in">Late In (minutes)</label>
            <input type="number" name="late_in" class="form-control" value="{{ $empPresence->late_in }}" min="0" placeholder="Enter late minutes">
        </div>
        <div class="form-group">
            <label for="early_out">Early Out (minutes)</label>
            <input type="number" name="early_out" class="form-control" value="{{ $empPresence->early_out }}" min="0" placeholder="Enter early minutes">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
