@extends('layouts.owner_main')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dashboard Owner</h1>
        <h3>Total Pendapatan: <span class="text-success">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </span></h3>
    </div>

    <!-- Grafik -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h5>Grafik Total Pendapatan</h5>
            <canvas id="pendapatanChart"></canvas>
        </div>
        <div class="col-md-6">
            <h5>Grafik Rating Review</h5>
            <p>(Belum ada data)</p>
        </div>
    </div>

    <!-- Kelas Baru -->
    <h5>Kelas Baru Ditambahkan:</h5>
    <div class="row">
        @foreach ($kelasBaru as $kelas)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h6>{{ $kelas->kelas_name }}</h6>
                        <p>Kapasitas: {{ $kelas->kelas_kapasitas }} orang</p>
                        <p>Harga: Rp {{ number_format($kelas->kelas_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pendapatanChart').getContext('2d');
    const pendapatanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($pendapatanPeriode->pluck('periode')),
            datasets: [{
                label: 'Total Pendapatan',
                data: @json($pendapatanPeriode->pluck('total')),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection