@extends('layouts.member_main')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">Jelajah Studio</h1>
    <form action="{{ route('jelajah.studio') }}" method="GET" class="mb-4">
        <input type="text" name="search" class="form-control" placeholder="Cari Studio..." value="{{ $search ?? '' }}">
    </form>
    <div class="row">
        @forelse ($studios as $studio)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <a href="{{ route('studio.detail', $studio->studio_uuid) }}">
                        <img src="{{ asset('public/images/studio_logos/' . $studio->studio_logo) }}" class="card-img-top" alt="{{ $studio->studio_name }}">
                    </a>
                    <div class="card-body">
                        <h5>{{ $studio->studio_name }}</h5>
                        <p>{{ $studio->studio_lokasi }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada studio yang ditemukan.</p>
        @endforelse
    </div>
</div>
@endsection