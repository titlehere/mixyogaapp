@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Review Kelas</h2>
    <div class="card p-4 shadow-sm">
        <h5><strong>Detail Kelas</strong></h5>
        <p>
            <strong>Kelas:</strong> {{ $order->jadwal->kelas->kelas_name }}<br>
            <strong>Studio:</strong> {{ $order->jadwal->kelas->studio->studio_name }}<br>
        </p>

        <h5><strong>Berikan Review</strong></h5>
        <form action="{{ route('review.submit', $order->booking_uuid) }}" method="POST">
            @csrf
            <label for="review_rating">Rating (1-5)</label>
            <select name="review_rating" id="review_rating" class="form-select mb-3" required>
                <option value="">-- Pilih Rating --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>

            <label for="review_komen">Komentar</label>
            <textarea name="review_komen" id="review_komen" class="form-control mb-3" rows="3"></textarea>

            <button type="submit" class="btn btn-success w-100">Kirim Review</button>
        </form>
    </div>
</div>
@endsection
