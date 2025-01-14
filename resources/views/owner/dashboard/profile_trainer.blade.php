@extends('layouts.owner_main')

@section('content')
<div class="container">
    <!-- Judul di tengah -->
    <h1 class="text-center mb-5">Data Trainer Studio Yoga</h1>
    
    <div class="row justify-content-center">
        @foreach ($trainers as $trainer)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm p-3">
                <div class="text-center mt-3">
                    <!-- Foto trainer bulat -->
                    @if ($trainer->trainer_foto)
                        <img src="{{ asset('public/images/trainer_foto/' . $trainer->trainer_foto) }}" 
                            alt="Foto Trainer" 
                            class="rounded-circle" 
                            style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                        <div class="text-muted text-center py-3">Tidak ada foto</div>
                    @endif
                </div>
                <div class="card-body text-center">
                    <!-- Menampilkan nama dan umur -->
                    <h5 class="card-title">{{ $trainer->trainer_name }}</h5>
                    <p class="text-muted">Umur: {{ $trainer->trainer_umur }}</p>
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <!-- Tombol Edit dan Hapus -->
                        <a href="{{ route('owner.edit_trainer', $trainer->trainer_uuid) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('owner.destroy_trainer', $trainer->trainer_uuid) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus trainer ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Tombol navigasi di bawah -->
    <div class="text-center mt-4">
        <a href="{{ route('owner.tambah_trainer') }}" class="btn btn-success">Tambah Trainer</a>
        <a href="{{ route('owner.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
