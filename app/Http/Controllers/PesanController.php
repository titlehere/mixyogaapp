<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    // Menampilkan riwayat pesanan member
    public function showOrders()
    {
        // Ambil user dari session
        $user = session('user');

        // Ambil data pemesanan berdasarkan status
        $ongoingOrders = Pemesanan::with('jadwal')
            ->where('member_uuid', $user->member_uuid)
            ->where('booking_status', 'ongoing')
            ->get();

        $completedOrders = Pemesanan::with('jadwal')
            ->where('member_uuid', $user->member_uuid)
            ->where('booking_status', 'completed')
            ->get();

        $cancelledOrders = Pemesanan::with('jadwal')
            ->where('member_uuid', $user->member_uuid)
            ->where('booking_status', 'cancelled')
            ->get();

        // Return ke view pesan.blade.php
        return view('member.dashboard.pesan', [
            'title' => 'Riwayat Pemesanan',
            'ongoingOrders' => $ongoingOrders,
            'completedOrders' => $completedOrders,
            'cancelledOrders' => $cancelledOrders
        ]);
    }
}