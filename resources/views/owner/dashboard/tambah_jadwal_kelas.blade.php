@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
    <h1>Tambah Jadwal untuk Kelas: {{ $kelas->kelas_name }}</h1>
    <form action="{{ route('jadwal.store', $kelas->kelas_uuid) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="jadwal_tgl" class="form-label">Tanggal</label>
            <input type="date" name="jadwal_tgl" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="jadwal_wkt" class="form-label">Waktu (contoh: 07:30 - 10:00)</label>
            <input type="text" name="jadwal_wkt" class="form-control" placeholder="Masukkan waktu, contoh: 07:30 - 10:00" required>
        </div>

        <div class="mb-3">
            <label for="trainer_uuid" class="form-label">Trainer</label>
            <select name="trainer_uuid" class="form-control" required>
                @foreach ($trainers as $trainer)
                    <option value="{{ $trainer->trainer_uuid }}">{{ $trainer->trainer_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jadwal_status" class="form-label">Status</label>
            <select name="jadwal_status" class="form-control" required>
                <option value="Belum Mulai">Belum Mulai</option>
                <option value="Berlangsung">Berlangsung</option>
                <option value="Selesai">Selesai</option>
                <option value="Batal">Batal</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Jadwal</button>
        <a href="{{ route('kelas.jadwal', $kelas->kelas_uuid) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection