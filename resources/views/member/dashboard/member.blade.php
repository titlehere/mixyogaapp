@extends('layouts.member_main')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Dashboard Member</h1>
    <p>Selamat datang di dashboard member, {{ session('user')->member_name }}!</p>

    <!-- Search Bar -->
    <div class="mb-5">
        <input type="text" class="form-control" placeholder="Cari studio yoga (nama, lokasi, harga, jenis kelas)">
    </div>

    <!-- Studio Yoga Terpopuler -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary">Studio Yoga Terpopuler</h2>
            <a href="{{ route('jelajah.studio') }}" class="btn btn-primary">Jelajah Studio</a>
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
            <a href="{{ route('jelajah.kelas') }}" class="btn btn-primary">Jelajah Kelas</a>
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
    <br>
</div>
@endsection