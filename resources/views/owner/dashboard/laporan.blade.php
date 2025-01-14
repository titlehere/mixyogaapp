@extends('layouts.owner_main')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Laporan Studio</h1>

    <!-- Tabel Laporan Periode -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Periode Awal</th>
                    <th>Periode Akhir</th>
                    <th>Total Pendapatan</th>
                    <th>Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $laporanPeriode->tanggal_pertama ?? '-' }}</td>
                    <td>{{ $laporanPeriode->tanggal_terakhir ?? '-' }}</td>
                    <td>Rp {{ number_format($laporanPeriode->total_pendapatan ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $laporanPeriode->total_transaksi ?? 0 }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pendapatan Per Kelas -->
    <div class="table-responsive mb-4">
        <h3 class="mb-3">Pendapatan Per Kelas</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendapatanPerKelas as $kelas)
                    <tr>
                        <td>{{ $kelas->kelas_name }}</td>
                        <td>Rp {{ number_format($kelas->jadwals->sum('pembayarans_sum_payment_nominal'), 0, ',', '.') }}</td>
                    </tr>
                @endforeach            
            </tbody>
        </table>
    </div>

    <!-- Review dan Rating -->
    <div class="table-responsive mb-4">
        <h3 class="mb-3">Rating dan Komentar Member</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kelas</th>
                    <th>Member</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($review->review_date)->format('d-m-Y') }}</td>
                        <td>{{ $review->jadwal->kelas->kelas_name ?? 'Tidak Tersedia' }}</td>
                        <td>{{ $review->member->member_name ?? 'Tidak Tersedia' }}</td>
                        <td>{{ $review->review_rating }}</td>
                        <td>{{ $review->review_komen }}</td>
                    </tr>
                @endforeach            
            </tbody>                        
        </table>
    </div>

    <!-- Tombol Cetak -->
    <a href="{{ route('owner.laporan.cetak') }}" target="_blank" class="btn btn-primary">Cetak Laporan</a>
</div>
@endsection