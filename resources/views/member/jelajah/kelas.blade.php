@extends('layouts.member_main')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Jelajah Kelas</h2>
    <form action="{{ route('jelajah.kelas') }}" method="GET" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari Kelas..." value="{{ $search ?? '' }}">
    </form>

    <div class="row">
        @forelse ($classes as $class)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5>{{ $class->kelas_name }}</h5>
                        <p>Kapasitas: {{ $class->kelas_kapasitas }} orang</p>
                        <p>Harga: Rp {{ number_format($class->kelas_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">Tidak ada kelas yang ditemukan.</div>
        @endforelse
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
</div>
@endsection
