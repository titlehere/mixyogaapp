@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
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
                    <td>
                        <a href="{{ route('jadwal.edit', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jadwal.destroy', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        <a href="{{ route('jadwal.member.pesan', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" class="btn btn-info btn-sm">Member Pesan</a>
                        <a href="{{ route('jadwal.member.review', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" class="btn btn-info btn-sm">Member Review</a>
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