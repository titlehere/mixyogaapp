<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Str;

class PembayaranController extends Controller
{
    /**
     * Menampilkan form pembayaran
     */
    public function showPaymentForm($booking_uuid)
    {
        $order = Pemesanan::with('jadwal.kelas.studio')->where('booking_uuid', $booking_uuid)->firstOrFail();

        return view('member.pembayaran.form', [
            'order' => $order,
            'title' => 'Pembayaran'
        ]);
    }

    /**
     * Proses pembayaran
     */
    public function processPayment(Request $request, $booking_uuid)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $order = Pemesanan::where('booking_uuid', $booking_uuid)->firstOrFail();

        Pembayaran::create([
            'payment_uuid' => (string) Str::uuid(),
            'booking_uuid' => $booking_uuid,
            'studio_uuid' => $order->jadwal->kelas->studio->studio_uuid,
            'payment_method' => $request->payment_method,
            'payment_nominal' => $order->jadwal->kelas->kelas_harga,
            'payment_date' => now()->toDateString(),
            'payment_status' => 'Paid',
        ]);

        // Update status pemesanan menjadi "Verification"
        $order->update(['booking_status' => 'Verification']);

        return redirect()->route('member.pesan')->with('success', 'Pembayaran berhasil, mohon unggah bukti pembayaran untuk verifikasi.');
    }

    /**
     * Menampilkan form unggah bukti pembayaran
     */
    public function showUploadForm($booking_uuid)
    {
        $order = Pemesanan::where('booking_uuid', $booking_uuid)->firstOrFail();

        return view('member.pembayaran.upload_bukti', [
            'order' => $order,
            'title' => 'Unggah Bukti Pembayaran'
        ]);
    }

    /**
     * Proses unggah bukti pembayaran
     */
    public function uploadBukti(Request $request, $booking_uuid)
    {
        $request->validate([
            'bukti_pembayaran' => ['required'], // Validasi file
        ]);
    
        $file = $request->file('bukti_pembayaran');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/bukti_pembayaran'), $filename);
    
        $pembayaran = Pembayaran::where('booking_uuid', $booking_uuid)->firstOrFail();
        $pembayaran->update(['payment_bukti' => $filename]);
    
        $order = Pemesanan::where('booking_uuid', $booking_uuid)->firstOrFail();
        $order->update(['booking_status' => 'Completed']);
    
        return redirect()->route('member.pesan')->with('success', 'Bukti pembayaran berhasil diunggah dan pesanan selesai.');
    }    

    /**
     * Menampilkan bukti pembayaran untuk member
     */
    public function showBukti($booking_uuid)
    {
        $pembayaran = Pembayaran::where('booking_uuid', $booking_uuid)->firstOrFail();
    
        return view('member.pembayaran.lihat_bukti', [
            'pembayaran' => $pembayaran,
            'title' => 'Bukti Pembayaran'
        ]);
    }

    /**
     * Menampilkan bukti pembayaran untuk owner
     */
    public function lihatBukti($payment_uuid)
    {
        $pembayaran = Pembayaran::where('payment_uuid', $payment_uuid)->firstOrFail();

        return view('owner.dashboard.lihat_bukti', [
            'pembayaran' => $pembayaran,
            'title' => 'Bukti Pembayaran Member'
        ]);
    }
}