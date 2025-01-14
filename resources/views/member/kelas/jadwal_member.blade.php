@extends('layouts.member_main')

@section('content')
<div class="container mt-5">
    @php
        \Carbon\Carbon::setLocale('id'); // Mengatur locale ke bahasa Indonesia
    @endphp
    <h1>Jadwal Kelas: {{ $kelas->kelas_name }}</h1>
    <p><strong>Deskripsi Kelas:</strong> {{ $kelas->kelas_desk }}</p>

    <!-- Tampilkan pesan error jika ada -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Trainer</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwals as $jadwal)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jadwal_tgl)->translatedFormat('l') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jadwal_tgl)->format('d-m-Y') }}</td>
                    <td>{{ $jadwal->jadwal_wkt }}</td>
                    <td>{{ $jadwal->trainer->trainer_name }}</td>
                    <td>{{ $jadwal->jadwal_status }}</td>
                    <td>
                        @if ($jadwal->jadwal_status == 'Belum Mulai')
                            @if ($jadwal->pemesanan_count < $jadwal->kelas->kelas_kapasitas)
                                <form action="{{ route('pemesanan.store', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Book</button>
                                </form>
                            @else
                                <button class="btn btn-danger btn-sm" disabled>Penuh</button>
                            @endif
                        @else
                            <button class="btn btn-secondary btn-sm" disabled>Tidak Tersedia</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection