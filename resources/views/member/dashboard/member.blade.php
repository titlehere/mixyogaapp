@extends('layouts.member_main')

@section('content')

<style>
    .studio-logo {
        height: 150px;
        width: 150px;
        object-fit: cover;
        display: block;
        margin: 0 auto; /* Pusatkan gambar di dalam card */
    }
</style>

<div class="container mt-5">
    <h1 class="text-primary">Dashboard Member</h1>
    <p>Selamat datang di dashboard member, {{ session('user')->member_name }}!</p>

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
                <div class="card me-3" style="min-width: 250px;">
                    <a href="{{ route('studio.detail', $studio->studio_uuid) }}">
                        <img src="{{ asset('public/images/studio_logos/' . $studio->studio_logo) }}" class="card-img-top studio-logo" alt="{{ $studio->studio_name }}">
                    </a>
                    <div class="card-body text-center">
                        <h5>{{ $studio->studio_name }}</h5>
                        {{-- <p>{{ $studio->studio_lokasi }}</p> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection