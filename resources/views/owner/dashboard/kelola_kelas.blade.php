@extends('layouts.owner_main')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Kelola Kelas Yoga</h1>
    @if ($classes->isEmpty())
        <p class="text-center">Belum ada kelas yang ditambahkan.</p>
    @else
        <div class="row">
            @foreach ($classes as $class)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        @if ($class->kelas_thumbnail)
                            <img src="{{ asset('public/images/kelas_thumbnails/' . $class->kelas_thumbnail) }}" alt="Thumbnail" class="card-img-top" style="max-height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $class->kelas_name }}</h5>
                            <p class="card-text">Kapasitas: {{ $class->kelas_kapasitas }}</p>
                            <p class="card-text">Harga: Rp {{ number_format($class->kelas_harga, 0, ',', '.') }}</p>
                            <p class="card-text">Deskripsi: {{ $class->kelas_desk }}</p>
                            <div class="d-flex justify-content-between">
                                <!-- Perbarui sesuai route -->
                                <a href="{{ route('owner.edit_kelas', $class->kelas_uuid) }}" class="btn btn-success btn-sm">Edit</a>
                                <a href="{{ route('kelas.jadwal', $class->kelas_uuid) }}" class="btn btn-info btn-sm">Jadwal Kelas</a>
                                {{-- <a href="{{ route('kelas.member', $class->kelas_uuid) }}" class="btn btn-primary btn-sm">Member Pesan</a> --}}
                                <form action="{{ route('kelas.destroy', $class->kelas_uuid) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
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
    @endif
    <div class="d-flex justify-content-center">
        <a href="{{ route('owner.tambah_kelas') }}" class="btn btn-primary">Tambah Kelas</a>
    </div>
    <br>
    <div class="d-flex justify-content-center">
        <a href="{{ route('owner.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection