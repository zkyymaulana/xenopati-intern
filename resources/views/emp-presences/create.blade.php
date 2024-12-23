@extends('layouts.app')

@section('content')
    <h1>Add Presence</h1>
    <form action="{{ route('emp-presences.store') }}" method="POST">
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
            <label for="check_in">Check In</label>
            <input type="datetime-local" name="check_in" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="check_out">Check Out</label>
            <input type="datetime-local" name="check_out" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="late_in">Late In (minutes)</label>
            <input type="number" name="late_in" class="form-control" min="0" placeholder="Enter late minutes">
        </div>
        <div class="form-group">
            <label for="early_out">Early Out (minutes)</label>
            <input type="number" name="early_out" class="form-control" min="0" placeholder="Enter early minutes">
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
@endsection
