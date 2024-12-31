@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1>Tambah Kelas Baru</h1>

    <form action="{{ route('owner.store_kelas') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="studio_uuid" value="{{ $studio->studio_uuid }}">

        <div class="mb-3">
            <label for="kelas_name" class="form-label">Nama Kelas</label>
            <input type="text" id="kelas_name" name="kelas_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kelas_desk" class="form-label">Deskripsi Kelas</label>
            <textarea id="kelas_desk" name="kelas_desk" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="kelas_kapasitas" class="form-label">Kapasitas Kelas (Orang)</label>
            <input type="number" id="kelas_kapasitas" name="kelas_kapasitas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kelas_harga" class="form-label">Harga Kelas (Rp)</label>
            <input type="number" id="kelas_harga" name="kelas_harga" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kelas_thumbnail" class="form-label">Thumbnail Kelas</label>
            <input type="file" id="kelas_thumbnail" name="kelas_thumbnail" class="form-control" accept="image/jpeg,image/png,image/jpg">
        </div>

        <button type="submit" class="btn btn-success">Simpan Kelas</button>
        <a href="{{ route('owner.kelola_kelas') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection