@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Perhitungan Gaji</h1>
        <form id="payroll-form">
            <div class="row mb-3">
                <div class="col-md-4">
                    <select name="month" class="form-select">
                        @foreach ($months as $key => $month)
                            <option value="{{ $key + 1 }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="year" class="form-select">
                        @for ($i = 2020; $i <= date('Y'); $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Hitung</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
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
                    <td>${row.employee}</td>
                    <td>${row.basic_salary}</td>
                    <td>${row.bonus}</td>
                    <td>${row.bpjs}</td>
                    <td>${row.jp}</td>
                    <td>${row.loan}</td>
                    <td>${row.total_salary}</td>
                </tr>
            `;
                    });
                });
        });
    </script>
@endsection
