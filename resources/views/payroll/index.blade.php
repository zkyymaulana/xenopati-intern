@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Perhitungan Gaji</h1>

        <form id="payroll-form">
            <div class="row mb-3">
                <!-- Dropdown for Month Selection -->
                <div class="col-md-4">
                    <label for="month" class="form-label">Bulan</label>
                    <select name="month" id="month" class="form-select">
                        @foreach ($months as $key => $month)
                            <option value="{{ $key + 1 }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown for Year Selection -->
                <div class="col-md-4">
                    <label for="year" class="form-label">Tahun</label>
                    <select name="year" id="year" class="form-select">
                        @for ($i = 2020; $i <= date('Y') + 5; $i++) <!-- Extend range to 5 years ahead -->
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Button for Calculate -->
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-80">Hitung</button>
                </div>
            </div>
        </form>

        <!-- Payroll Results Table -->
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Periode</th>
                    <th>Pegawai</th>
                    <th>Gaji Pokok</th>
                    <th>Bonus</th>
                    <th>BPJS</th>
                    <th>JP</th>
                    <th>Cicilan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="payroll-results">
                <!-- Dynamic rows will be appended here -->
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('payroll-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const url = "{{ route('payroll.calculate') }}";

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                const results = document.getElementById('payroll-results');
                results.innerHTML = '';

                data.forEach(row => {
                    results.innerHTML += `
                        <tr>
                            <td>${row.period}</td>
                            <td>${row.employee}</td>
                            <td>${row.basic_salary.toLocaleString('id-ID')}</td>
                            <td>${row.bonus.toLocaleString('id-ID')}</td>
                            <td>${row.bpjs.toLocaleString('id-ID')}</td>
                            <td>${row.jp.toLocaleString('id-ID')}</td>
                            <td>${row.loan.toLocaleString('id-ID')}</td>
                            <td>${row.total_salary.toLocaleString('id-ID')}</td>
                        </tr>
                    `;
                });
            });
        });
    </script>
@endsection
