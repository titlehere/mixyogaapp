<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PemesananController extends Controller
{
        public function store(Request $request, $kelas_uuid, $jadwal_uuid)
    {
        $member_uuid = session('user')->member_uuid;

        // Ambil data jadwal
        $jadwal = Jadwal::with('pemesanan')->findOrFail($jadwal_uuid);

        // Periksa apakah kapasitas sudah penuh
        if ($jadwal->pemesanan_count >= $jadwal->kelas->kelas_kapasitas) {
            return redirect()->back()->with('error', 'Kapasitas kelas sudah penuh.');
        }

        // Buat pemesanan baru
        Pemesanan::create([
            'booking_uuid' => (string) Str::uuid(),
            'jadwal_uuid' => $jadwal_uuid,
            'member_uuid' => $member_uuid,
            'booking_date' => now()->toDateString(),
            'booking_status' => 'Booked',
        ]);

        return redirect()->route('member.pesan')->with('success', 'Berhasil memesan jadwal.');
    }

    public function showOrders()
{
    $user = session('user');

    // Periksa apakah session 'user' ada dan memiliki properti member_uuid
    if (!$user || !isset($user->member_uuid)) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $ongoingOrders = Pemesanan::with(['jadwal.kelas', 'pembayaran'])
        ->where('member_uuid', $user->member_uuid)
        ->whereIn('booking_status', ['Booked', 'Verification'])
        ->get();

    $completedOrders = Pemesanan::with(['jadwal.kelas'])
        ->where('member_uuid', $user->member_uuid)
        ->where('booking_status', 'Completed')
        ->get();

    $cancelledOrders = Pemesanan::with(['jadwal.kelas'])
        ->where('member_uuid', $user->member_uuid)
        ->where('booking_status', 'Cancelled')
        ->get();

    return view('member.dashboard.pesan', [
        'title' => 'Riwayat Pemesanan',
        'ongoingOrders' => $ongoingOrders,
        'completedOrders' => $completedOrders,
        'cancelledOrders' => $cancelledOrders,
    ]);
}

    public function cancel($booking_uuid)
    {
        $order = Pemesanan::where('booking_uuid', $booking_uuid)->firstOrFail();
        $order->update(['booking_status' => 'Cancelled']);

        return redirect()->route('member.pesan')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function complete($booking_uuid)
    {
        $order = Pemesanan::where('booking_uuid', $booking_uuid)->firstOrFail();
        $order->update(['booking_status' => 'Completed']);

        return redirect()->route('member.pesan')->with('success', 'Pembayaran berhasil diselesaikan.');
    }
}
