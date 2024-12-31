@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1>Edit Kelas Yoga</h1>
    <form action="{{ route('owner.update_kelas', $kelas->kelas_uuid) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Untuk metode HTTP PUT -->
        
        <div class="mb-3">
            <label for="kelas_name" class="form-label">Nama Kelas</label>
            <input type="text" id="kelas_name" name="kelas_name" class="form-control" value="{{ $kelas->kelas_name }}" required>
        </div>

        <div class="mb-3">
            <label for="kelas_desk" class="form-label">Deskripsi Kelas</label>
            <textarea id="kelas_desk" name="kelas_desk" class="form-control" rows="4">{{ $kelas->kelas_desk }}</textarea>
        </div>

        <div class="mb-3">
            <label for="kelas_kapasitas" class="form-label">Kapasitas Kelas (Orang)</label>
            <input type="number" id="kelas_kapasitas" name="kelas_kapasitas" class="form-control" value="{{ $kelas->kelas_kapasitas }}" required>
        </div>

        <div class="mb-3">
            <label for="kelas_harga" class="form-label">Harga Kelas (Rp)</label>
            <input type="number" id="kelas_harga" name="kelas_harga" class="form-control" value="{{ $kelas->kelas_harga }}" required>
        </div>

        <div class="mb-3">
            <label for="kelas_thumbnail" class="form-label">Thumbnail Kelas</label>
            <input type="file" id="kelas_thumbnail" name="kelas_thumbnail" class="form-control" accept="image/jpeg,image/png,image/jpg">
            @if ($kelas->kelas_thumbnail)
                <img src="{{ asset('public/images/kelas_thumbnails/' . $kelas->kelas_thumbnail) }}" alt="Thumbnail" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('owner.kelola_kelas') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection