@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Daftar Review dari Member</h1>
    <h5>Kelas: {{ $kelas->kelas_name }}</h5>
    <h5>Tanggal: {{ \Carbon\Carbon::parse($jadwal->jadwal_tgl)->format('d-m-Y') }}</h5>
    <h5>Waktu: {{ $jadwal->jadwal_wkt }}</h5>
    <h5>Trainer: {{ $jadwal->trainer->trainer_name }}</h5>
    <h5>Status: {{ $jadwal->jadwal_status }}</h5>
    <br>

    <h5>Total Rating: {{ $totalRating }}</h5>

    <!-- Rata-rata Rating -->
<p><strong>Rata-rata Rating:</strong>
    @for ($i = 0; $i < floor($averageRating); $i++)
        <i class="fa fa-star text-warning"></i>
    @endfor
    @if ($averageRating - floor($averageRating) > 0)
        <i class="fa fa-star-half-alt text-warning"></i>
    @endif
    ({{ number_format($averageRating, 1) }})
</p>
    
<br>

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
                <td>
                    @for ($i = 0; $i < floor($review->review_rating); $i++)
                        <i class="fa fa-star text-warning"></i>
                    @endfor
                    @if ($review->review_rating - floor($review->review_rating) > 0)
                        <i class="fa fa-star-half-alt text-warning"></i>
                    @endif
                    ({{ $review->review_rating }})
                </td>
                <td>{{ $review->review_komen }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada review untuk jadwal ini.</td>
            </tr>
        @endforelse
    </tbody>
</table>

    <a href="{{ route('kelas.jadwal', $kelas->kelas_uuid) }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection