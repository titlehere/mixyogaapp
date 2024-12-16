@extends('layouts.member_main')

@section('content')
<div class="container">
    <h2 class="mb-4">Profil Saya</h2>

    <!-- Notifikasi sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Update Profil -->
    <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="profile_photo" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept=".jpg, .jpeg, .png">
            @if ($user->profile_photo)
                <!-- Tampilkan gambar yang sudah diunggah -->
                <img src="{{ asset('public/images/profiles/' . $user->profile_photo) }}" 
                     alt="Foto Profil" class="img-thumbnail mt-2" width="100">
            @endif
        </div>         

        <div class="mb-3">
            <label for="member_name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="member_name" name="member_name" value="{{ $user->member_name }}" required>
        </div>

        <div class="mb-3">
            <label for="member_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="member_email" name="member_email" value="{{ $user->member_email }}" required>
        </div>

        <div class="mb-3">
            <label for="member_phone" class="form-label">No Telepon</label>
            <input type="text" class="form-control" id="member_phone" name="member_phone" value="{{ $user->member_phone }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <!-- Tombol kembali ke dashboard -->
        <a href="{{ route('member.dashboard') }}" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
    </form>

    <!-- Sejarah Review -->
    <h3 class="mt-5">Sejarah Review</h3>
    <ul class="list-group">
        @forelse ($reviews as $review)
            <li class="list-group-item">
                <strong>Rating:</strong> {{ $review->review_rating }} | 
                <strong>Komentar:</strong> {{ $review->review_komen }} |
                <strong>Tanggal:</strong> {{ $review->review_date }}
            </li>
        @empty
            <li class="list-group-item">Belum ada review.</li>
        @endforelse
    </ul>
</div>
@endsection