@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1>Tambah Trainer Baru</h1>
    <form action="{{ route('owner.store_trainer') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Identitas Trainer</h3>
        <div class="mb-3">
            <label for="trainer_name" class="form-label">Nama Trainer</label>
            <input type="text" name="trainer_name" id="trainer_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="trainer_desk" class="form-label">Deskripsi (Opsional)</label>
            <textarea name="trainer_desk" id="trainer_desk" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="trainer_umur" class="form-label">Umur</label>
            <input type="number" name="trainer_umur" id="trainer_umur" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="trainer_sertif" class="form-label">Sertifikasi (Pisah dengan koma & Opsional)</label>
            <input type="text" name="trainer_sertif" id="trainer_sertif" class="form-control">
        </div>
        <h3>Akun Sosmed Trainer (Opsional)</h3>
        <div class="mb-3">
            <label for="trainer_link_ig" class="form-label">Link IG (https://www.instragam.com/[nama_akun])</label>
            <input type="url" name="trainer_link_ig" id="trainer_link_ig" class="form-control">
        </div>
        <div class="mb-3">
            <label for="trainer_link_fb" class="form-label">Link FB (https://www.facebook.com/[nama_akun])</label>
            <input type="url" name="trainer_link_fb" id="trainer_link_fb" class="form-control">
        </div>
        <div class="mb-3">
            <label for="trainer_link_tw" class="form-label">Link X (https://x.com/[nama_akun])</label>
            <input type="url" name="trainer_link_tw" id="trainer_link_tw" class="form-control">
        </div>
        <div class="mb-3">
            <label for="trainer_foto" class="form-label">Foto Trainer</label>
            <input type="file" name="trainer_foto" id="trainer_foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('owner.profile_trainer') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection