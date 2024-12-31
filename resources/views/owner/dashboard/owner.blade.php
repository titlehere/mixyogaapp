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

    <div class="row mb-4">
        <div class="col-md-6">
            <h5>Grafik Total Pendapatan</h5>
            <canvas id="pendapatanChart"></canvas>
        </div>
        <div class="col-md-6">
            <h5>Grafik Rating Review</h5>
            <canvas id="ratingChart" width="300" height="300"></canvas> <!-- Tambahkan width dan height -->
        </div>        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Grafik Total Pendapatan
        const pendapatanCtx = document.getElementById('pendapatanChart').getContext('2d');
        const pendapatanChart = new Chart(pendapatanCtx, {
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
    
        // Grafik Rating Review
        const ratingCtx = document.getElementById('ratingChart').getContext('2d');
        const ratingChart = new Chart(ratingCtx, {
            type: 'doughnut',
            data: {
                labels: ['Rata-rata Rating', 'Total Rating'],
                datasets: [{
                    data: [{{ $averageRating }}, {{ $totalRating }}],
                    backgroundColor: ['rgba(255, 205, 86, 0.6)', 'rgba(54, 162, 235, 0.6)'],
                    borderColor: ['rgba(255, 205, 86, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });
    </script>

    <!-- Kelas Baru -->
    <h5>Kelas Baru Ditambahkan:</h5>
    @if ($kelasBaru->isEmpty())
        <p class="text-muted">Belum ada kelas baru yang ditambahkan.</p>
    @else
        <div class="row">
            @foreach ($kelasBaru as $kelas)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm text-center">
                        @if ($kelas->kelas_thumbnail)
                            <img src="{{ asset('public/images/kelas_thumbnails/' . $kelas->kelas_thumbnail) }}" 
                                alt="{{ $kelas->kelas_name }}" 
                                class="card-img-top" 
                                style="height: 150px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">{{ $kelas->kelas_name }}</h6>
                            <p class="card-text">Kapasitas: {{ $kelas->kelas_kapasitas }} orang</p>
                            <p class="card-text">Harga: Rp {{ number_format($kelas->kelas_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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