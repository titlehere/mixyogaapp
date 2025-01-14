@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Daftar Kelas di {{ $studio->studio_name }}</h2>

    <div class="row overflow-auto">
        @if ($classes->isEmpty())
            <p class="text-center text-secondary">Belum ada kelas tersedia</p>
        @else
            @foreach ($classes as $kelas)
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

    <!-- Tombol Kembali -->
    <a href="{{ route('studio.detail', $studio->studio_uuid) }}" class="btn btn-secondary mt-3">Kembali ke Detail Studio</a>
</div>
@endsection