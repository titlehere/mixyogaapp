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
            @php
                $fullStars = floor($averageRating);
                $halfStar = $averageRating - $fullStars >= 0.5;
                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
            @endphp
            @for ($i = 0; $i < $fullStars; $i++)
                <i class="fas fa-star text-warning"></i>
            @endfor
            @if ($halfStar)
                <i class="fas fa-star-half-alt text-warning"></i>
            @endif
            @for ($i = 0; $i < $emptyStars; $i++)
                <i class="far fa-star text-warning"></i>
            @endfor
            ({{ $averageRating ? number_format($averageRating, 1) : 'Belum ada rating' }} dari {{ $totalReviews }} ulasan)
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
    @if ($studio->classes->isEmpty())
        <p class="text-center text-secondary">Belum ada kelas tersedia</p>
    @else
        @foreach ($studio->classes as $kelas)
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="{{ asset('public/images/kelas_thumbnails/' . ($kelas->kelas_thumbnail ?? 'default_thumbnail.jpg')) }}" 
                    alt="{{ $kelas->kelas_name }}" 
                    class="card-img-top" 
                    style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $kelas->kelas_name }}</h5>
                    <p class="card-text">Harga: Rp {{ number_format($kelas->kelas_harga, 0, ',', '.') }}</p>
                    
                    <!-- Rata-rata Rating -->
                    <p class="card-text">
                        <strong>Rata-rata Rating:</strong>
                        @php
                            $averageRating = $kelas->reviews->avg('review_rating');
                            $totalReviews = $kelas->reviews->count();
                        @endphp
                        @if ($totalReviews > 0)
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($averageRating))
                                    <i class="fas fa-star text-warning"></i>
                                @elseif ($i - $averageRating < 1)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span>({{ number_format($averageRating, 1) }}, {{ $totalReviews }} ulasan)</span>
                        @else
                            Belum ada rating
                        @endif
                    </p>
                    
                    <!-- Kapasitas -->
                    <p class="card-text">
                        <strong>Kapasitas:</strong> {{ $kelas->kelas_kapasitas }}
                    </p>
                    
                    <!-- Tombol -->
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('kelas.detail', $kelas->kelas_uuid) }}" class="btn btn-primary me-2">Lihat Detail Kelas</a>
                        @if ($kelas->hasActiveJadwal)
                            <a href="{{ route('kelas.jadwal.member', $kelas->kelas_uuid) }}" class="btn btn-success">Pesan Kelas</a>
                        @else
                            <button class="btn btn-secondary" disabled>Tidak Tersedia Jadwal</button>
                        @endif
                    </div>                    
                </div>
            </div>
        </div>
        @endforeach
    @endif
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