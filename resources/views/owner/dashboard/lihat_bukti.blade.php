@extends('layouts.owner_main')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-4">Bukti Pembayaran Member</h2>
    <div class="card p-4 shadow-sm">
        <h5><strong>Detail Pembayaran</strong></h5>
        <p>
            <strong>Metode:</strong> {{ $pembayaran->payment_method }}<br>
            <strong>Nominal:</strong> Rp {{ number_format($pembayaran->payment_nominal, 0, ',', '.') }}<br>
            <strong>Tanggal:</strong> {{ $pembayaran->payment_date }}
        </p>
        <h5 class="mt-3"><strong>File Bukti Pembayaran</strong></h5>
        @if ($pembayaran->payment_bukti)
            @php
                $fileExtension = pathinfo($pembayaran->payment_bukti, PATHINFO_EXTENSION);
            @endphp

            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                <img src="{{ asset('public/uploads/bukti_pembayaran/' . $pembayaran->payment_bukti) }}" alt="Bukti Pembayaran" class="img-fluid mt-3" style="max-width: 100%; height: auto;">
            @elseif ($fileExtension == 'pdf')
                <iframe src="{{ asset('public/uploads/bukti_pembayaran/' . $pembayaran->payment_bukti) }}" width="100%" height="600px" style="border: none;" class="mt-3"></iframe>
            @else
                <p class="text-warning mt-3">File tidak tersedia atau jenis file tidak didukung untuk ditampilkan langsung.</p>
                {{-- <a href="{{ asset('public/uploads/bukti_pembayaran/' . $pembayaran->payment_bukti) }}" target="_blank" class="btn btn-success">Unduh Bukti Pembayaran</a> --}}
            @endif
        @else
            <p class="text-muted">Tidak ada bukti pembayaran tersedia.</p>
        @endif
    </div>
</div>
@endsection
