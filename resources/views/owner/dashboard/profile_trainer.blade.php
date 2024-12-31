@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1>Data Trainer Studio Yoga</h1>
    <div class="row">
        @foreach ($trainers as $trainer)
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                @if ($trainer->trainer_foto)
                    <img src="{{ asset('public/images/trainer_foto/' . $trainer->trainer_foto) }}" 
                        alt="Foto Trainer" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                @else
                    <div class="text-muted text-center py-5">Tidak ada foto</div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $trainer->trainer_name }}</h5>
                    <p>{{ $trainer->trainer_desk }}</p>
                    <p>Umur: {{ $trainer->trainer_umur }}</p>
                    <p>Sertifikat: {{ $trainer->trainer_sertif }}</p>
                    <div class="d-flex justify-content-between">
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
    <div class="text-center mt-4">
        <a href="{{ route('owner.tambah_trainer') }}" class="btn btn-success">Tambah Trainer</a>
        <a href="{{ route('owner.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
