@extends('layouts.owner_main')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Laporan Studio</h1>

    <!-- Tabel Laporan -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Periode Laporan</th>
                    <th>Total Pendapatan</th>
                    <th>Jumlah Transaksi</th>
                    <th>Jumlah Pembatalan</th>
                    <th>Pendapatan Hilang</th>
                    <th>Status Laporan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanPeriode as $laporan)
                    <tr>
                        <td>{{ $laporan->periode }}</td>
                        <td>Rp {{ number_format($laporan->total_pendapatan, 0, ',', '.') }}</td>
                        <td>{{ $laporan->jumlah_transaksi }}</td>
                        <td>{{ $laporan->jumlah_pembatalan }}</td>
                        <td>Rp {{ number_format($laporan->pendapatan_hilang, 0, ',', '.') }}</td>
                        <td>{{ $laporan->jumlah_pembatalan > 0 ? 'Gagal' : 'Sukses' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pendapatan Per Kelas -->
    <div class="table-responsive mb-4">
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

    <!-- Tombol Cetak -->
    <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
</div>
@endsection