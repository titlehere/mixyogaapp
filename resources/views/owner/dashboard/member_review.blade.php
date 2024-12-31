@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
    <h1>Daftar Review dari Member</h1>
    <h2>Kelas: {{ $kelas->kelas_name }}</h2>
    <h3>Jadwal: {{ $jadwal->jadwal_tgl }} - {{ $jadwal->jadwal_wkt }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto Profil</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Rating</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $review)
                <tr>
                    <td>
                        <img src="{{ asset('public/images/profiles/' . ($review->member->profile_photo ?? 'default.png')) }}" 
                             alt="Foto Profil" 
                             style="width: 50px; height: 50px; border-radius: 50%;">
                    </td>
                    <td>{{ $review->member->member_name }}</td>
                    <td>{{ $review->member->member_email }}</td>
                    <td>{{ $review->member->member_phone }}</td>
                    <td>{{ $review->review_rating }}</td>
                    <td>{{ $review->review_komen }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada review untuk jadwal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection