{{-- test_new --}}

@extends('layouts.main')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <header class="text-center mb-5">
        <h1 class="text-primary">Selamat Datang di Mix Yoga</h1>
        <p class="text-secondary">Temukan kelas yoga terbaik untuk Anda!</p>
    </header>

    <!-- Search Bar -->
    <div class="mb-5">
        <input type="text" class="form-control" placeholder="Cari studio yoga (nama, lokasi, harga, jenis kelas)">
    </div>

    <!-- Studio Yoga Terpopuler -->
    <section class="mb-5">
        <h2 class="text-primary mb-4">Studio Yoga Terpopuler</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card border-primary">
                    <img src="{{ asset('public/images/popular_studio_1.jpg') }}" class="card-img-top" alt="Studio 1">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Studio Yoga #1</h5>
                        <button class="btn btn-link text-primary">Lihat Detail</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card border-primary">
                    <img src="{{ asset('public/images/popular_studio_2.jpg') }}" class="card-img-top" alt="Studio 2">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Studio Yoga #2</h5>
                        <button class="btn btn-link text-primary">Lihat Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promosi Studio Yoga -->
    <section class="mb-5">
        <div class="bg-primary text-white text-center p-4 rounded">
            <h3 class="mb-2">Promosi Studio Yoga</h3>
            <p>Telah terdaftar di Aplikasi Mix Yoga!</p>
        </div>
    </section>

    <!-- Rekomendasi Kelas -->
    <section>
        <h2 class="text-primary mb-4">Rekomendasi Kelas</h2>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card border-primary">
                    <img src="{{ asset('public/images/class_recommendation_1.jpg') }}" class="card-img-top" alt="Kelas Yoga 1">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Kelas Yoga #1</h5>
                        <button class="btn btn-link text-primary">Lihat Detail</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="card border-primary">
                    <img src="{{ asset('public/images/class_recommendation_2.jpg') }}" class="card-img-top" alt="Kelas Yoga 2">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Kelas Yoga #2</h5>
                        <button class="btn btn-link text-primary">Lihat Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection