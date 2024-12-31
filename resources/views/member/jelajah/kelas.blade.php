@extends('layouts.member_main')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">Jelajah Kelas</h1>
    <form action="{{ route('jelajah.kelas') }}" method="GET" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari Kelas..." value="{{ $search ?? '' }}">
    </form>
    <div class="row">
        @forelse ($classes as $class)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <a href="{{ route('kelas.detail', $class->kelas_uuid) }}">
                        <img src="{{ asset('public/images/kelas_thumbnails/' . $class->kelas_thumbnail) }}" class="card-img-top" alt="{{ $class->kelas_name }}">
                    </a>
                    <div class="card-body">
                        <h5>{{ $class->kelas_name }}</h5>
                        <p>Harga: Rp {{ number_format($class->kelas_harga, 0, ',', '.') }}</p>
                        <p>Studio: {{ $class->studio->studio_name }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada kelas yang ditemukan.</p>
        @endforelse
    </div>
</div>
@endsection