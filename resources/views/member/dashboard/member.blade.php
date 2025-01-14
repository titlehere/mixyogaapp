@extends('layouts.member_main')

@section('content')

<div class="container mt-5">
    <h1 class="text-primary">Dashboard Member</h1>
    <p>Selamat datang di dashboard member, {{ session('user')->member_name ?? 'Member' }}!</p>

    <!-- Search Bar -->
    <div class="mb-5">
        <form action="{{ route('member.dashboard') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Pencarian (nama, lokasi, dan kelas yoga)" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>

    <!-- Kelas Yoga Terbaru -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">Kelas Yoga Terbaru</h2>
            <a href="{{ route('jelajah.kelas') }}" class="btn btn-primary">Jelajah Kelas</a>
        </div>
        <div class="d-flex overflow-auto">
            @foreach ($latestClasses as $class)
                <div class="card me-3" style="min-width: 250px;">
                    <a href="{{ route('kelas.detail', $class->kelas_uuid) }}">
                        <img src="{{ asset('public/images/kelas_thumbnails/' . $class->kelas_thumbnail) }}" class="card-img-top" alt="{{ $class->kelas_name }}" style="height: 150px; object-fit: cover;">
                    </a>
                    <div class="card-body">
                        <h5>{{ $class->kelas_name }}</h5>
                        <p>Harga: Rp {{ number_format($class->kelas_harga, 0, ',', '.') }}</p>
                        <p>Studio: {{ $class->studio->studio_name ?? '-' }}</p>
                        <p>
                            <strong>Rating:</strong>
                            @if ($class->averageRating > 0)
                                {{ number_format($class->averageRating, 1) }} 
                                <span class="text-warning">
                                    @for ($i = 0; $i < floor($class->averageRating); $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                    @if ($class->averageRating - floor($class->averageRating) > 0)
                                        <i class="fa fa-star-half-alt"></i>
                                    @endif
                                </span>
                                ({{ $class->reviews_count }} ulasan)
                            @else
                                Belum ada rating
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Studio Yoga Terbaru -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">Studio Yoga Terbaru</h2>
            <a href="{{ route('jelajah.studio') }}" class="btn btn-primary">Jelajah Studio</a>
        </div>
        <div class="d-flex overflow-auto">
            @foreach ($latestStudios as $studio)
                <div class="card me-3 text-center" style="min-width: 250px; border: none;">
                    <a href="{{ route('studio.detail', $studio->studio_uuid) }}">
                        <img src="{{ asset('public/images/studio_logos/' . $studio->studio_logo) }}" 
                            class="card-img-top rounded-circle mx-auto mt-3" 
                            style="max-width: 150px; max-height: 150px; object-fit: cover;" 
                            alt="{{ $studio->studio_name }}">
                    </a>
                    <div class="card-body">
                        <h5>{{ $studio->studio_name }}</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection