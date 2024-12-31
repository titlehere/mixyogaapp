@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
    <h1>Daftar Member yang Memesan Jadwal</h1>
    <h2>Kelas: {{ $kelas->kelas_name }}</h2>
    <h3>Jadwal: {{ $jadwal->jadwal_tgl }} - {{ $jadwal->jadwal_wkt }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto Profil</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $member)
                <tr>
                    <td>
                        <img src="{{ asset('public/images/profiles/' . ($member->profile_photo ?? 'default.png')) }}" 
                             alt="Foto Profil" 
                             style="width: 50px; height: 50px; border-radius: 50%;">
                    </td>
                    <td>{{ $member->member_name }}</td>
                    <td>{{ $member->member_email }}</td>
                    <td>{{ $member->member_phone }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada member yang memesan jadwal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection