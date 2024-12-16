@extends('layouts.member_main')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">Riwayat Pemesanan</h2>

    <!-- Tabs Status Pesanan -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="ongoing-tab" data-bs-toggle="pill" data-bs-target="#ongoing" type="button">Berlangsung</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button">Selesai</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="cancelled-tab" data-bs-toggle="pill" data-bs-target="#cancelled" type="button">Dibatalkan</button>
        </li>
        <a href="{{ route('member.dashboard') }}" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="pills-tabContent">
        <!-- Tab Berlangsung -->
        <div class="tab-pane fade show active" id="ongoing">
            @forelse ($ongoingOrders as $order)
                @include('member.partials.order_card', ['order' => $order])
            @empty
                <p>Tidak ada pesanan yang sedang berlangsung.</p>
            @endforelse
        </div>

        <!-- Tab Selesai -->
        <div class="tab-pane fade" id="completed">
            @forelse ($completedOrders as $order)
                @include('member.partials.order_card', ['order' => $order])
            @empty
                <p>Tidak ada pesanan yang selesai.</p>
            @endforelse
        </div>

        <!-- Tab Dibatalkan -->
        <div class="tab-pane fade" id="cancelled">
            @forelse ($cancelledOrders as $order)
                @include('member.partials.order_card', ['order' => $order])
            @empty
                <p>Tidak ada pesanan yang dibatalkan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection