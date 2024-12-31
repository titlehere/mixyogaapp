@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <!-- Logo Studio -->
    <div class="text-center mb-4">
        <img src="{{ asset('public/images/studio_logos/' . $studio->studio_logo) }}" alt="{{ $studio->studio_name }}" class="rounded-circle" style="width: 150px; height: 150px;">
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <h2>{{ $studio->studio_name }}</h2>
        <div>
            {{-- <button class="btn btn-outline-secondary me-2">Bagikan</button> --}}
            <form action="{{ route('save.studio', $studio->studio_uuid) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Deskripsi Studio -->
    <div class="mt-4">
        <h5>Deskripsi Studio</h5>
        <p>{{ $studio->studio_desk }}</p>
    </div>

    <!-- Rata-rata Rating -->
    <div>
        <p>
            <strong>Rata-rata Rating:</strong> 
            {{ $averageRating ? number_format($averageRating, 1) : 'Belum ada rating' }} 
            ({{ $totalReviews }} ulasan)
        </p>
    </div>

    <!-- Tombol Navigasi -->
    <div class="mb-4">
        <a href="{{ route('studio.trainers', $studio->studio_uuid) }}" class="btn btn-outline-primary me-2">Lihat Trainer</a>
        <a href="{{ route('studio.classes', $studio->studio_uuid) }}" class="btn btn-outline-primary">Lihat Semua Kelas</a>
    </div>

    <!-- Kelas Tersedia -->
    <h5 class="mt-4">Kelas Tersedia</h5>
    <div class="row overflow-auto">
        @foreach ($studio->classes as $kelas)
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="{{ asset('public/images/kelas_thumbnails/' . $kelas->kelas_thumbnail) }}" alt="{{ $kelas->kelas_name }}" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $kelas->kelas_name }}</h5>
                    <p class="card-text">Harga: Rp {{ number_format($kelas->kelas_harga, 0, ',', '.') }}</p>
                    <a href="{{ route('kelas.detail', $kelas->kelas_uuid) }}" class="btn btn-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Informasi Studio -->
    <div class="mt-5">
        <h5>Informasi Studio</h5>
        <p><strong>Pemilik:</strong> {{ $studio->owner->owner_name }}</p>
        <p><strong>No. Telepon:</strong> <a href="https://wa.me/{{ $studio->owner->owner_phone }}" target="_blank">{{ $studio->owner->owner_phone }}</a></p>
        <p><strong>Alamat:</strong> <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($studio->studio_lokasi) }}" target="_blank">{{ $studio->studio_lokasi }}</a></p>
    </div>

    <!-- Google Maps Embed -->
    <div class="mt-4">
        <iframe src="https://maps.google.com/maps?q={{ urlencode($studio->studio_lokasi) }}&output=embed" class="w-100" style="height: 300px;"></iframe>
    </div>
</div>
@endsection