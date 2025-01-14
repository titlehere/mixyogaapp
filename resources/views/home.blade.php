@extends('layouts.main')

@section('content')
<div class="container py-5">
    

      <!-- Header -->
    <header class="text-center mb-5">
        <h1 class="text-primary fw-bold">Selamat Datang di Mix Yoga</h1>
        <p class="text-secondary">Temukan kelas yoga terbaik, jadilah lebih sehat dan bugar bersama Mix Yoga!</p>
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Segera Bergabung Sekarang</a>
    </header>

    <!-- Slide Show Benefit -->
    <section class="mb-5">
        <h2 class="text-primary text-center mb-4">Keunggulan Bergabung dengan Mix Yoga</h2>
        <div id="benefitCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('public/images/benefit_1.png') }}" class="d-block w-100 rounded" style="max-height: 400px;" alt="Benefit 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Jaringan Studio Yoga Terluas</h5>
                        <p>Jelajahi studio yoga berkualitas di berbagai lokasi.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('public/images/benefit_2.png') }}" class="d-block w-100 rounded" style="max-height: 400px;" alt="Benefit 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Beragam Pilihan Kelas</h5>
                        <p>Pilih kelas yang sesuai dengan kebutuhan dan tingkat kemampuan Anda.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('public/images/benefit_3.png') }}" class="d-block w-100 rounded" style="max-height: 400px;" alt="Benefit 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Manajemen Jadwal Mudah</h5>
                        <p>Atur jadwal kelas dan pantau aktivitas Anda langsung di dashboard.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#benefitCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#benefitCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Studio Yoga -->
    <section class="mb-5 text-center">
        <h2 class="text-primary mb-4">Tersedia Studio Yoga Terpercaya</h2>
        <div class="row justify-content-center">
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0">
                        <img src="{{ asset('public/images/std_yoga_'.$i.'.jpg') }}" 
                            class="card-img-top rounded-circle mx-auto d-block my-3" 
                            style="max-width: 200px; max-height: 200px; object-fit: cover;" 
                            alt="Studio Yoga #{{ $i }}">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Studio Yoga #{{ $i }}</h5>
                            <a href="{{ route('login') }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- Promosi Studio Yoga -->
    <section class="mb-5 text-center">
        <h3 class="text-primary mb-4">Promosi Studio Yoga</h3>
        <div class="p-4 rounded mx-auto" style="max-width: 800px;">
            <a href="{{ route('login') }}">
                <img src="{{ asset('public/images/promosi_studio.jpg') }}" 
                    alt="Promosi Studio" 
                    class="img-fluid rounded" 
                    style="max-width: 100%; height: auto; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            </a>
        </div>
    </section>

    <!-- Jadilah Mitra Kami -->
    <section class="text-center my-5">
        <h2 class="text-primary mb-4">Jadilah Mitra Kami</h2>
        <p class="text-secondary">Kelola studio yoga Anda dengan mudah bersama Mix Yoga. Dapatkan keuntungan eksklusif dengan bergabung sebagai mitra kami.</p>
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Login Sebagai Owner Studio</a>
    </section>

    <!-- Fitur dan Keunggulan -->
    <section class="text-white py-5 bg-primary">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">Kenapa Harus Mix Yoga?</h2>
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <i class="bi bi-person-check-fill display-4"></i>
                    <h5 class="mt-3">Trainer Profesional</h5>
                    <p>Didukung oleh trainer berpengalaman dan bersertifikat.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <i class="bi bi-calendar-check-fill display-4"></i>
                    <h5 class="mt-3">Pengelolaan Jadwal Mudah</h5>
                    <p>Atur jadwal latihan dan pantau aktivitas dengan praktis.</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <i class="bi bi-graph-up display-4"></i>
                    <h5 class="mt-3">Statistik Aktivitas</h5>
                    <p>Melacak kemajuan dan aktivitas dengan fitur statistik yang informatif.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Screenshot Dashboard -->
    <section class="mb-5">
        <h2 class="text-primary mb-4 text-center">Lihat Dashboard Member dan Trainer</h2>
        <div class="row text-center">
            <div class="col-md-6 mb-3">
                <img src="{{ asset('public/images/dashboard_member.jpg') }}" class="img-fluid rounded shadow" alt="Dashboard Member">
                <p class="mt-2">Dashboard Member</p>
            </div>
            <div class="col-md-6 mb-3">
                <img src="{{ asset('public/images/dashboard_trainer.jpg') }}" class="img-fluid rounded shadow" alt="Dashboard Trainer">
                <p class="mt-2">Dashboard Trainer</p>
            </div>
        </div>
    </section> --}}
</div>
@endsection