@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1>Edit Profil & Studio</h1>
    <form action="{{ route('owner.update_studio') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3>Profil Owner</h3>
        <div class="mb-3">
            <label for="owner_name" class="form-label">Nama Owner</label>
            <input type="text" id="owner_name" name="owner_name" class="form-control" value="{{ $user->owner_name }}" required>
        </div>
        <div class="mb-3">
            <label for="owner_email" class="form-label">Email Owner</label>
            <input type="email" id="owner_email" name="owner_email" class="form-control" value="{{ $user->owner_email }}" required>
        </div>
        <div class="mb-3">
            <label for="owner_phone" class="form-label">Nomor Telepon</label>
            <input type="text" id="owner_phone" name="owner_phone" class="form-control" value="{{ $user->owner_phone }}" required>
        </div>
    
        <h3>Informasi Studio</h3>
        <div class="mb-3">
            <label for="studio_name" class="form-label">Nama Studio</label>
            <input type="text" id="studio_name" name="studio_name" class="form-control" value="{{ $studio->studio_name }}" required>
        </div>
        <div class="mb-3">
            <label for="studio_lokasi" class="form-label">Alamat Studio (Tulis nama jalan lengkap, nomor bangunan, RT/RW (jika ada), kelurahan, kecamatan, kota, provinsi, kode pos, dan negara.)</label>
            <input type="text" id="studio_lokasi" name="studio_lokasi" class="form-control" value="{{ $studio->studio_lokasi }}" required>
        </div>
        <div class="mb-3">
            <label for="studio_desk" class="form-label">Deskripsi Studio</label>
            <textarea id="studio_desk" name="studio_desk" class="form-control" rows="4">{{ $studio->studio_desk }}</textarea>
        </div>
        <div class="mb-3">
            <label for="studio_logo" class="form-label">Logo Studio</label>
            <input type="file" id="studio_logo" name="studio_logo" class="form-control" accept="image/jpeg,image/png,image/jpg">
            @if ($studio->studio_logo)
            <img src="{{ asset('public/images/studio_logos/' . $studio->studio_logo) }}" alt="Logo Studio" class="img-thumbnail mb-2" style="max-width: 200px;">
            @endif
        </div>
    
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('owner.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </form>    
</div>
@endsection