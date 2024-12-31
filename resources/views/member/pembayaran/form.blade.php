@extends('layouts.member_main')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Pembayaran</h2>
    <div class="card p-4 shadow-sm">
        <h5><strong>Detail Kelas</strong></h5>
        <p>
            <strong>Studio:</strong> {{ $order->jadwal->kelas->studio->studio_name }}<br>
            <strong>Kelas:</strong> {{ $order->jadwal->kelas->kelas_name }}<br>
            <strong>Harga:</strong> Rp {{ number_format($order->jadwal->kelas->kelas_harga, 0, ',', '.') }}
        </p>

        <h5><strong>Metode Pembayaran</strong></h5>
        <form action="{{ route('pembayaran.process', $order->booking_uuid) }}" method="POST">
            @csrf
            <select name="payment_method" class="form-select mb-3" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="COD">Cash on Delivery</option>
            </select>
            <button type="submit" class="btn btn-primary w-100">Bayar Pemesanan</button>
        </form>
    </div>
</div>
@endsection
