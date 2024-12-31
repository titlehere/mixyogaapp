@extends('layouts.main')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <header class="text-center mb-5">
        <h1 class="text-primary fw-bold">Selamat Datang di Mix Yoga</h1>
        <p class="text-secondary">Temukan kelas yoga terbaik untuk Anda!</p>
    </header>

    {{-- <!-- Search Bar -->
    <div class="mb-5">
        <input type="text" class="form-control" placeholder="Cari studio yoga (nama, lokasi, harga, jenis kelas)">
    </div> --}}

    <!-- Studio Yoga Terpopuler -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">Studio Yoga Terpopuler</h2>
            {{-- <a href="#" class="btn btn-primary">Jelajah Studio</a> --}}
        </div>
        <div class="d-flex overflow-auto">
            @for ($i = 1; $i <= 5; $i++)
                <div class="card border-primary me-3" style="min-width: 250px;">
                    <img src="{{ asset('public/images/popular_studio_'.$i.'.jpg') }}" class="card-img-top" alt="Studio Yoga #{{ $i }}">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Studio Yoga #{{ $i }}</h5>
                        <button class="btn btn-link text-primary">Lihat Detail</button>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- Promosi Studio Yoga -->
    <section class="mb-5">
        <div class="bg-primary text-white text-center p-4 rounded">
            <h3 class="mb-2">Promosi Studio Yoga</h3>
            {{-- <a href="{{ route('studio.promosi') }}"> --}}
                <img src="{{ asset('public/images/promosi_studio.jpg') }}" alt="Promosi Studio" class="img-fluid rounded" style="max-height: 300px;">
            </a>
        </div>
    </section>

    <!-- Rekomendasi Kelas -->
    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">Rekomendasi Kelas</h2>
            {{-- <a href="#" class="btn btn-primary">Jelajah Kelas</a> --}}
        </div>
        <div class="d-flex overflow-auto">
            @for ($i = 1; $i <= 5; $i++)
                <div class="card border-primary me-3" style="min-width: 250px;">
                    <img src="{{ asset('public/images/class_recommendation_'.$i.'.jpg') }}" class="card-img-top" alt="Kelas Yoga #{{ $i }}">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Kelas Yoga #{{ $i }}</h5>
                        <button class="btn btn-link text-primary">Lihat Detail</button>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- About Us Section -->
    <section class="text-white py-5" style="background: url('{{ asset('public/images/about_bg.jpg') }}') no-repeat center center; background-size: cover;">
        <div class="container text-center py-5" style="background: rgba(0, 0, 0, 0.6); border-radius: 10px;">
            <h2 class="fw-bold mb-4">About Us</h2>
            <p class="lead">
                Kami menyediakan berbagai kelas yoga dari studio terbaik di sekitar Anda. 
                Bergabunglah bersama kami untuk mencapai keseimbangan dan kesehatan tubuh serta pikiran.
            </p>
        </div>
    </section>

</div>
@endsection