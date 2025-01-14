@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Daftar Trainer di {{ $studio->studio_name }}</h2>
    <div class="row">
        @forelse ($trainers as $trainer)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <!-- Foto Trainer -->
                        @if ($trainer->trainer_foto)
                            <img src="{{ asset('public/images/trainer_foto/' . $trainer->trainer_foto) }}" alt="Foto {{ $trainer->trainer_name }}" class="img-thumbnail rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light text-center py-5 rounded-circle" style="width: 150px; height: 150px;">Tidak ada Foto</div>
                        @endif

                        <!-- Nama Trainer -->
                        <h5 class="card-title">{{ $trainer->trainer_name }}</h5>
                        
                        <!-- Deskripsi -->
                        <p>{{ $trainer->trainer_desk ?? 'Tidak ada deskripsi.' }}</p>
                        
                        <!-- Umur -->
                        <p><strong>Umur:</strong> {{ $trainer->trainer_umur ?? 'Tidak tersedia' }} tahun</p>
                        
                        <!-- Sertifikat -->
                        @if ($trainer->trainer_sertif)
                        <p><strong>Sertifikat:</strong> {{ $trainer->trainer_sertif }}</p>
                        @endif
                        
                        <!-- Sosial Media -->
                        <div class="d-flex justify-content-center">
                            @if ($trainer->trainer_link_fb)
                                <a href="{{ $trainer->trainer_link_fb }}" target="_blank" class="me-2">
                                    <img src="{{ asset('public/images/icons/facebook.png') }}" alt="Facebook" style="width: 30px;">
                                </a>
                            @endif
                            @if ($trainer->trainer_link_ig)
                                <a href="{{ $trainer->trainer_link_ig }}" target="_blank" class="me-2">
                                    <img src="{{ asset('public/images/icons/instagram.png') }}" alt="Instagram" style="width: 30px;">
                                </a>
                            @endif
                            @if ($trainer->trainer_link_tw)
                                <a href="{{ $trainer->trainer_link_tw }}" target="_blank" class="me-2">
                                    <img src="{{ asset('public/images/icons/twitter.png') }}" alt="Twitter" style="width: 30px;">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Belum ada trainer yang terdaftar di studio ini.</p>
        @endforelse
    </div>
    <a href="{{ route('studio.detail', $studio->studio_uuid) }}" class="btn btn-secondary">Kembali ke Detail Studio</a>
</div>
@endsection