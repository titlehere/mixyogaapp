@extends('layouts.owner_main')

@section('content')
<div class="container mt-5">
    <h1>Edit Jadwal untuk Kelas: {{ $kelas->kelas_name }}</h1>
    <form action="{{ route('jadwal.update', [$kelas->kelas_uuid, $jadwal->jadwal_uuid]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="jadwal_tgl" class="form-label">Tanggal</label>
            <input type="date" name="jadwal_tgl" class="form-control" value="{{ $jadwal->jadwal_tgl }}" required>
        </div>

        <div class="mb-3">
            <label for="jadwal_wkt" class="form-label">Waktu (contoh: 07:30 - 10:00)</label>
            <input type="text" name="jadwal_wkt" class="form-control" value="{{ $jadwal->jadwal_wkt }}" required>
        </div>

        <div class="mb-3">
            <label for="trainer_uuid" class="form-label">Trainer</label>
            <select name="trainer_uuid" class="form-control" required>
                @foreach ($trainers as $trainer)
                    <option value="{{ $trainer->trainer_uuid }}" {{ $trainer->trainer_uuid == $jadwal->trainer_uuid ? 'selected' : '' }}>
                        {{ $trainer->trainer_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jadwal_status" class="form-label">Status</label>
            <select name="jadwal_status" class="form-control" required>
                <option value="Belum Mulai" {{ $jadwal->jadwal_status == 'Belum Mulai' ? 'selected' : '' }}>Belum Mulai</option>
                <option value="Berlangsung" {{ $jadwal->jadwal_status == 'Berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                <option value="Selesai" {{ $jadwal->jadwal_status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Batal" {{ $jadwal->jadwal_status == 'Batal' ? 'selected' : '' }}>Batal</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('kelas.jadwal', $kelas->kelas_uuid) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
