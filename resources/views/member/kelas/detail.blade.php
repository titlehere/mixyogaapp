@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <!-- Judul Halaman -->
    <h2 class="mb-4 text-center">{{ $kelas->kelas_name }}</h2> <!-- Judul kelas -->

    <div class="row">
        <!-- Thumbnail Kelas -->
        <div class="col-md-6">
            @if ($kelas->kelas_thumbnail)
                <!-- Menampilkan gambar kelas -->
                <img src="{{ asset('public/images/kelas_thumbnails/' . $kelas->kelas_thumbnail) }}" 
                     alt="Thumbnail Kelas" 
                     class="img-fluid rounded">
            @else
                <!-- Menampilkan placeholder jika tidak ada gambar -->
                <div class="bg-light text-center py-5 rounded">Tidak ada gambar</div>
            @endif
        </div>

        <!-- Informasi Kelas -->
        <div class="col-md-6">
            <!-- Tombol Simpan -->
            <div class="d-flex justify-content-end mb-3">
                <form action="{{ route('save.class', $kelas->kelas_uuid) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
            <!-- Informasi Umum -->
            <h4>Informasi Kelas</h4>
            <p>
                <!-- Menampilkan rata-rata rating -->
                <strong>Rata-rata Rating:</strong>
                @if ($averageRating > 0)
                    {{ number_format($averageRating, 1) }}
                    <span class="text-warning">
                        @for ($i = 0; $i < floor($averageRating); $i++)
                            <i class="fa fa-star"></i>
                        @endfor
                        @if ($averageRating - floor($averageRating) > 0)
                            <i class="fa fa-star-half-alt"></i>
                        @endif
                    </span>
                    ({{ $totalReviews }} ulasan)
                @else
                    Belum ada rating
                @endif
            </p>            
            <p><strong>Kapasitas:</strong> {{ $kelas->kelas_kapasitas }} orang</p> <!-- Kapasitas kelas -->
            <p><strong>Harga:</strong> Rp {{ number_format($kelas->kelas_harga, 0, ',', '.') }}</p> <!-- Harga kelas -->
            <p><strong>Asal Studio:</strong> 
                <a href="{{ route('studio.detail', $kelas->studio->studio_uuid) }}" class="text-primary">
                    {{ $kelas->studio->studio_name }}
                </a>
            </p>
            <!-- Tombol Pesan Kelas -->
            @if ($kelas->jadwals->count() > 0)
                <a href="{{ route('kelas.jadwal.member', $kelas->kelas_uuid) }}" 
                   class="btn btn-success">
                   Pesan Kelas
                </a> <!-- Tombol pesan kelas -->
            @else
                <button class="btn btn-secondary" disabled>Tidak Tersedia Jadwal</button>
            @endif
        </div>
    </div>

    <!-- Deskripsi Kelas -->
    <div class="mt-4">
        <h5>Deskripsi Kelas</h5> <!-- Judul Deskripsi -->
        <p>{{ $kelas->kelas_desk }}</p> <!-- Isi deskripsi -->
    </div>
</div>
@endsection