<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    public function showPaymentForm($booking_uuid)
    {
        // Ambil data pemesanan
        $order = Pemesanan::with('jadwal.kelas.studio')->where('booking_uuid', $booking_uuid)->firstOrFail();

        return view('member.pembayaran.form', [
            'order' => $order,
            'title' => 'Pembayaran'
        ]);
    }

    public function processPayment(Request $request, $booking_uuid)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $order = Pemesanan::where('booking_uuid', $booking_uuid)->firstOrFail();

        // Simpan pembayaran
        Pembayaran::create([
            'payment_uuid' => (string) Str::uuid(),
            'booking_uuid' => $booking_uuid,
            'studio_uuid' => $order->jadwal->kelas->studio->studio_uuid,
            'payment_method' => $request->payment_method,
            'payment_nominal' => $order->jadwal->kelas->kelas_harga,
            'payment_date' => now()->toDateString(),
            'payment_status' => 'Paid',
        ]);

        // Update status pemesanan
        $order->update(['booking_status' => 'Completed']);

        return redirect()->route('member.pesan', $booking_uuid)->with('success', 'Pembayaran berhasil!');
    }
}