@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Daftar Member yang Memesan Jadwal</h1>
    <h5>Kelas: {{ $kelas->kelas_name }}</h5>
    <h5>Tanggal: {{ \Carbon\Carbon::parse($jadwal->jadwal_tgl)->format('d-m-Y') }}</h5>
    <h5>Waktu: {{ $jadwal->jadwal_wkt }}</h5>
    <h5>Trainer: {{ $jadwal->trainer->trainer_name }}</h5>
    <h5>Status: {{ $jadwal->jadwal_status }}</h5>
    <br>

    <h5>Total Member: {{ $totalMembers }}</h5>
    <br>

    <table class="table">
        <thead>
            <tr>
                <th>Foto Profil</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $pemesanan)
            <tr>
                <td>
                    @if ($pemesanan->member?->profile_photo)
                        <img src="{{ asset('public/images/profiles/' . $pemesanan->member->profile_photo) }}" 
                             alt="Foto Profil" class="img-thumbnail" width="50">
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $pemesanan->member?->member_name ?? '-' }}</td>
                <td>{{ $pemesanan->member?->member_email ?? '-' }}</td>
                <td>{{ $pemesanan->member?->member_phone ?? '-' }}</td>
                <td>
                    @if ($pemesanan->booking_status == 'Booked')
                        <span class="badge bg-primary">Booked</span>
                    @elseif ($pemesanan->booking_status == 'Verification')
                        <span class="badge bg-warning text-dark">Verification</span>
                    @elseif ($pemesanan->booking_status == 'Completed')
                        <span class="badge bg-success">Completed</span>
                    @elseif ($pemesanan->booking_status == 'Cancelled')
                        <span class="badge bg-danger">Cancelled</span>
                    @else
                        <span class="badge bg-secondary">Unknown</span>
                    @endif
                </td>
                <td>
                    @if ($pemesanan->booking_status == 'Verification' || $pemesanan->booking_status == 'Completed')
                        @if ($pemesanan->pembayaran && $pemesanan->pembayaran->payment_bukti)
                            <a href="{{ route('owner.bukti', $pemesanan->pembayaran->payment_uuid) }}" class="btn btn-success btn-sm">Lihat Bukti Pembayaran</a>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Tidak Ada Bukti</button>
                        @endif
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Tidak Ada Bukti</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>        
    </table>    
    <a href="{{ route('kelas.jadwal', $kelas->kelas_uuid) }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection