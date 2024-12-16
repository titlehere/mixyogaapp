<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <h5>{{ $order->jadwal->studio_name }} - {{ $order->jadwal->kelas_name }}</h5>
        <p>
            <strong>Hari:</strong> {{ $order->jadwal->day }}<br>
            <strong>Tanggal:</strong> {{ $order->booking_date }}<br>
            <strong>Waktu:</strong> {{ $order->jadwal->time }}<br>
            <strong>Alamat:</strong> {{ $order->jadwal->address }}<br>
            <strong>Harga:</strong> Rp {{ number_format($order->jadwal->price, 0, ',', '.') }}
        </p>
        <a href="{{ $order->jadwal->maps_link }}" target="_blank" class="btn btn-primary btn-sm">Google Maps</a>
        @if ($order->booking_status == 'ongoing')
            <button class="btn btn-danger btn-sm">Batalkan</button>
        @endif
    </div>
</div>