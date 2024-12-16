@extends('layouts.member_main')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Simpan Kelas & Studio</h2>

    <!-- Section Simpan Kelas -->
    <h4 class="mb-3">Kelas Disimpan:</h4>
    <div class="row">
        @forelse ($savedKelas as $kelas)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $kelas->kelas_name }}</h5>
                        <p class="card-text">{{ $kelas->kelas_desk }}</p>
                        <p class="card-text"><small>Harga: Rp{{ number_format($kelas->kelas_harga, 0, ',', '.') }}</small></p>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada kelas yang disimpan.</p>
        @endforelse
    </div>

    <!-- Section Simpan Studio -->
    <h4 class="mt-5 mb-3">Studio Disimpan:</h4>
    <div class="row">
        @forelse ($savedStudios as $studio)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $studio->studio_name }}</h5>
                        <p class="card-text">{{ $studio->studio_desk }}</p>
                        <p class="card-text"><small>Lokasi: {{ $studio->studio_lokasi }}</small></p>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada studio yang disimpan.</p>
        @endforelse
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
</div>
@endsection