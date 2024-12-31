@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <!-- Judul Halaman -->
    <h2 class="mb-4 text-center">{{ $kelas->kelas_name }}</h2>

    <div class="row">
        <!-- Thumbnail Kelas -->
        <div class="col-md-6">
            @if ($kelas->kelas_thumbnail)
                <img src="{{ asset('public/images/kelas_thumbnails/' . $kelas->kelas_thumbnail) }}" alt="Thumbnail Kelas" class="img-fluid rounded">
            @else
                <div class="bg-light text-center py-5 rounded">Tidak ada gambar</div>
            @endif
        </div>

        <!-- Informasi Kelas -->
        <div class="col-md-6">
            <div class="d-flex justify-content-end mb-3">
                <!-- Tombol Bagikan dan Simpan -->
                {{-- <button class="btn btn-outline-secondary me-2">Bagikan</button> --}}
                <form action="{{ route('save.class', $kelas->kelas_uuid) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
            <h4>Informasi Kelas</h4>
            <p>
                <strong>Rata-rata Rating:</strong> 
                {{ $averageRating ? number_format($averageRating, 1) : 'Belum ada rating' }} 
                ({{ $totalReviews }} ulasan)
            </p>
            <p><strong>Kapasitas:</strong> {{ $kelas->kelas_kapasitas }} orang</p>
            <p><strong>Harga:</strong> Rp {{ number_format($kelas->kelas_harga, 0, ',', '.') }}</p>
            <p><strong>Asal Studio:</strong> 
                <a href="{{ route('studio.detail', $kelas->studio->studio_uuid) }}" class="text-primary">
                    {{ $kelas->studio->studio_name }}
                </a>
            </p>
            <a href="{{ route('kelas.jadwal.member', $kelas->kelas_uuid) }}" class="btn btn-success">Booking Jadwal Kelas</a>
        </div>
    </div>

    <!-- Deskripsi Kelas -->
    <div class="mt-4">
        <h5>Deskripsi Kelas</h5>
        <p>{{ $kelas->kelas_desk }}</p>
    </div>
</div>
@endsection