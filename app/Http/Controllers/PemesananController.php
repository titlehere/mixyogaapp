<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PemesananController extends Controller
{
    public function store(Request $request, $kelas_uuid, $jadwal_uuid)
    {
        $member_uuid = session('user')->member_uuid;

        // Cek apakah member sudah memesan jadwal ini
        $existingOrder = Pemesanan::where('jadwal_uuid', $jadwal_uuid)
            ->where('member_uuid', $member_uuid)
            ->first();

        if ($existingOrder) {
            return redirect()->route('member.pesan')->with('error', 'Anda sudah memesan jadwal ini.');
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

        // Ambil data pemesanan berdasarkan status
        $ongoingOrders = Pemesanan::with('jadwal.kelas')
            ->where('member_uuid', $user->member_uuid)
            ->where('booking_status', 'Booked')
            ->get();

        $completedOrders = Pemesanan::with('jadwal.kelas')
            ->where('member_uuid', $user->member_uuid)
            ->where('booking_status', 'Completed')
            ->get();

        $cancelledOrders = Pemesanan::with('jadwal.kelas')
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