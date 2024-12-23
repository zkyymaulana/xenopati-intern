@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Salary Calculation</h1>
        @if (!session()->has('formSubmitted')) <!-- Form hanya ditampilkan jika belum disubmit -->
        <form id="payroll-form" action="{{ route('payroll.index') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="month" class="form-label">Bulan</label>
                    <select name="month" id="month" class="form-select">
                        @php
                            $currentMonth = date('n'); // Mengambil bulan saat ini (1-12)
                        @endphp
                        @foreach ($months as $key => $month)
                            <option value="{{ $key + 1 }}" {{ ($key + 1) == $currentMonth ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="year" class="form-label">Tahun</label>
                    <select name="year" id="year" class="form-select">
                        @php
                            $currentYear = date('Y'); // Mengambil tahun saat ini
                        @endphp
                        @for ($i = 2020; $i <= date('Y') + 5; $i++)
                            <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-80">Hitung</button>
                </div>
            </div>
        </form>
        @endif

        @if(isset($results) && count($results) > 0)
            <h2 class="mt-4">Salary calculation results</h2>
            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Employee</th>
                        <th>Basic Salary</th>
                        <th>Bonus</th>
                        <th>BPJS</th>
                        <th>JP</th>
                        <th>Loan</th>
                        <th>Total Salary</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>
                                @if (isset($result['month']) && isset($result['year']))
                                    {{ date('F', mktime(0, 0, 0, $result['month'], 1)) }} {{ $result['year'] }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $result['employee']->name }}</td>
                            <td>{{ $result['basic_salary'] }}</td>
                            <td>{{ $result['bonus'] }}</td>
                            <td>{{ $result['bpjs'] }}</td>
                            <td>{{ $result['jp'] }}</td>
                            <td>{{ $result['loan'] }}</td>
                            <td>{{ $result['total_salary'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
