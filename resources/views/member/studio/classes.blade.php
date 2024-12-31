@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Daftar Kelas di {{ $studio->studio_name }}</h2>

    <div class="row">
        @forelse ($classes as $class)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('public/images/kelas_thumbnails/' . $class->kelas_thumbnail) }}" alt="{{ $class->kelas_name }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $class->kelas_name }}</h5>
                        <p class="card-text">Harga: Rp {{ number_format($class->kelas_harga, 0, ',', '.') }}</p>
                        <a href="{{ route('kelas.detail', $class->kelas_uuid) }}" class="btn btn-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada kelas yang tersedia di studio ini.</p>
        @endforelse
    </div>
</div>
@endsection
