@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
    @php
        \Carbon\Carbon::setLocale('id'); // Mengatur locale ke bahasa Indonesia
    @endphp
    <h1>{{ $title }}</h1>
    <h2>Kelas: {{ $kelas->kelas_name }}</h2>
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
            @forelse ($jadwals as $jadwal)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jadwal_tgl)->translatedFormat('l') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->jadwal_tgl)->format('d-m-Y') }}</td>
                    <td>{{ $jadwal->jadwal_wkt }}</td>
                    <td>{{ $jadwal->trainer->trainer_name }}</td>
                    <td>{{ $jadwal->jadwal_status }}</td>
                    <td class="text-center">
                        <div class="mb-2">
                            <!-- Row 1: Edit & Hapus -->
                            <a href="{{ route('jadwal.edit', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="{{ route('jadwal.destroy', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                        <!-- Row 2: Member Pesan & Member Review -->
                        <div>
                            <a href="{{ route('jadwal.member.pesan', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" class="btn btn-info btn-sm text-white me-2" style="background-color: #17a2b8;">Lihat Member Pesan</a>
                            <a href="{{ route('jadwal.member.review', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" class="btn btn-success btn-sm">Lihat Member Review</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada jadwal</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('jadwal.create', $kelas->kelas_uuid) }}" class="btn btn-primary mb-3">Tambah Jadwal</a>
</div>
@endsection