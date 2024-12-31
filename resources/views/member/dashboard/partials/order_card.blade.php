<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('public/images/studio_logos/' . ($order->jadwal?->kelas?->studio?->studio_logo ?? 'default_logo.png')) }}" 
                         alt="Studio Logo" class="me-2" 
                         style="width: 50px; height: 50px; border-radius: 50%;">
                    <h5 class="m-0">{{ $order->jadwal?->kelas?->kelas_name ?? 'Kelas Tidak Ditemukan' }}</h5>
                </div>
                
                <p>
                    <strong>Studio:</strong> {{ $order->jadwal?->kelas?->studio?->studio_name ?? 'Studio Tidak Ditemukan' }}<br>
                    <strong>Harga:</strong> Rp {{ number_format($order->jadwal?->kelas?->kelas_harga ?? 0, 0, ',', '.') }}<br>
                    <strong>Status:</strong> {{ $order->booking_status ?? 'Status Tidak Ditemukan' }}
                </p>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <p>
                    <strong>Hari:</strong> {{ \Carbon\Carbon::parse($order->jadwal?->jadwal_tgl)->translatedFormat('l') ?? 'Tidak Ditemukan' }}<br>
                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($order->jadwal?->jadwal_tgl)->format('d-m-Y') ?? 'Tidak Ditemukan' }}<br>
                    <strong>Waktu:</strong> {{ $order->jadwal?->jadwal_wkt ?? 'Tidak Ditemukan' }}
                </p>
            </div>
        </div>

        <!-- Alamat -->
        <p>
            <strong>Alamat:</strong> 
            <a href="https://maps.google.com/maps?q={{ urlencode($order->jadwal?->kelas?->studio?->studio_lokasi ?? 'Lokasi Tidak Ditemukan') }}" 
                target="_blank" 
                class="text-primary">
                {{ $order->jadwal?->kelas?->studio?->studio_lokasi ?? 'Lokasi Tidak Ditemukan' }}
            </a>
        </p>

        <!-- Google Maps -->
        <iframe 
            src="https://maps.google.com/maps?q={{ urlencode($order->jadwal?->kelas?->studio?->studio_lokasi ?? 'Lokasi Tidak Ditemukan') }}&output=embed" 
            width="100%" 
            height="200" 
            frameborder="0" 
            style="border:0; border-radius: 8px;" 
            allowfullscreen="" 
            aria-hidden="false" 
            tabindex="0">
        </iframe>

        <!-- Tombol Aksi -->
        @if ($order->booking_status == 'Booked')
            <div class="mt-3">
                <!-- Form Batalkan -->
                <form action="{{ route('pemesanan.cancel', $order->booking_uuid) }}" method="POST" class="d-inline" 
                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan kelas ini?');">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-danger btn-sm">Batalkan</button>
                </form>

                <!-- Form Bayar -->
                <form action="{{ route('pembayaran.form', $order->booking_uuid) }}" method="GET" class="d-inline">
                    @csrf
                    <button class="btn btn-success btn-sm">Bayar</button>
                </form>
            </div>
        @elseif ($order->booking_status == 'Completed')
            <div class="mt-3">
                <!-- Form Review -->
                <form action="{{ route('review.form', $order->booking_uuid) }}" method="GET" class="d-inline">
                    @csrf
                    <button class="btn btn-primary btn-sm">Review</button>
                </form>
            </div>
        @endif
    </div>
</div>