@extends('layouts.member_main')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Profil Saya</h2>

    <!-- Notifikasi sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Update Profil -->
    <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="profile_photo" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="profile_photo" name="profile_photo" accept="image/jpeg,image/png,image/jpg">
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
    @if ($reviews->isEmpty())
        <p class="text-muted">Belum ada review yang diberikan.</p>
    @else
        <div class="row">
            @foreach ($reviews as $review)
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('public/images/studio_logos/' . $review->jadwal->kelas->studio->studio_logo) }}" 
                                 alt="Logo Studio" 
                                 class="me-3" 
                                 style="width: 50px; height: 50px; border-radius: 50%;">
                            <div>
                                <h5 class="card-title mb-0">{{ $review->jadwal->kelas->studio->studio_name }}</h5>
                                <small class="text-muted">{{ $review->jadwal->kelas->kelas_name }}</small>
                            </div>
                        </div>
                        <p class="mt-3 mb-1"><strong>Rating:</strong> {{ $review->review_rating }}</p>
                        <p class="mb-1"><strong>Komentar:</strong> {{ $review->review_komen }}</p>
                        <p class="text-muted"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($review->review_date)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection