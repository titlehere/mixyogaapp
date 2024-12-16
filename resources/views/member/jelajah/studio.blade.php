@extends('layouts.member_main')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Jelajah Studio</h2>
    <form action="{{ route('jelajah.studio') }}" method="GET" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari Studio..." value="{{ $search ?? '' }}">
    </form>

    <div class="row">
        @forelse ($studios as $studio)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h5>{{ $studio->studio_name }}</h5>
                        <p>{{ $studio->studio_lokasi }}</p>
                        <img src="{{ asset('public/images/studio_logos/' . $studio->studio_logo) }}" class="img-fluid" alt="Logo Studio">
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">Tidak ada studio yang ditemukan.</div>
        @endforelse
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
</div>
@endsection