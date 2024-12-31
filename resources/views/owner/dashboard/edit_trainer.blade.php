@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1>Edit Trainer</h1>
    <form action="{{ route('owner.update_trainer', $trainer->trainer_uuid) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h3>Identitas Trainer</h3>
        <div class="mb-3">
            <label for="trainer_name" class="form-label">Nama Trainer (Wajib diisi)</label>
            <input type="text" name="trainer_name" id="trainer_name" class="form-control" value="{{ $trainer->trainer_name }}" required>
        </div>
        <div class="mb-3">
            <label for="trainer_desk" class="form-label">Deskripsi</label>
            <textarea name="trainer_desk" id="trainer_desk" class="form-control">{{ $trainer->trainer_desk }}</textarea>
        </div>
        <div class="mb-3">
            <label for="trainer_umur" class="form-label">Umur (Wajib diisi)</label>
            <input type="number" name="trainer_umur" id="trainer_umur" class="form-control" value="{{ $trainer->trainer_umur }}" required>
        </div>
        <div class="mb-3">
            <label for="trainer_sertif" class="form-label">Sertifikasi (Pisah dengan koma & Opsional)</label>
            <input type="text" name="trainer_sertif" id="trainer_sertif" class="form-control" value="{{ $trainer->trainer_sertif }}">
        </div>
        <h3>Akun Sosmed Trainer (Opsional)</h3>
        <div class="mb-3">
            <label for="trainer_link_ig" class="form-label">Link IG (https://www.instragam.com/[nama_akun])</label>
            <input type="url" name="trainer_link_ig" id="trainer_link_ig" class="form-control" value="{{ $trainer->trainer_link_ig }}">
        </div>
        <div class="mb-3">
            <label for="trainer_link_fb" class="form-label">Link FB (https://www.facebook.com/[nama_akun])</label>
            <input type="url" name="trainer_link_fb" id="trainer_link_fb" class="form-control" value="{{ $trainer->trainer_link_fb }}">
        </div>
        <div class="mb-3">
            <label for="trainer_link_tw" class="form-label">Link TW (https://x.com/[nama_akun])</label>
            <input type="url" name="trainer_link_tw" id="trainer_link_tw" class="form-control" value="{{ $trainer->trainer_link_tw }}">
        </div>
        <div class="mb-3">
            <label for="trainer_foto" class="form-label">Foto Trainer</label>
            <input type="file" name="trainer_foto" id="trainer_foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
            @if ($trainer->trainer_foto)
                <img src="{{ asset('public/images/trainer_foto/' . $trainer->trainer_foto) }}" alt="Foto Trainer" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('owner.profile_trainer') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection