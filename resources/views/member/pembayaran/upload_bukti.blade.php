@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Unggah Bukti Pembayaran</h2>
    <div class="card p-4 shadow-sm">
        <form action="{{ route('pembayaran.upload', $order->booking_uuid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="bukti_pembayaran" class="form-label">Pilih File Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="form-control" id="bukti_pembayaran" accept=".jpg, .jpeg, .png" required>
                <small class="text-muted">Format file: JPG, PNG, atau JPEG.</small>
            </div>
            <button type="submit" class="btn btn-primary w-100">Unggah</button>
        </form>        
    </div>
</div>
@endsection