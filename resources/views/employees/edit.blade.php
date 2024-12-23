@extends('layouts.app')

@section('content')
    <h1>Edit Employee</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $employee->address }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}" required>
        </div>
        <div class="form-group">
            <label for="user_picture">User Picture</label>
            <input type="file" name="user_picture" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
