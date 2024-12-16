<?php

namespace App\Http\Controllers;

use App\Models\StudioYoga;
use App\Models\KelasYoga;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function dashboard()
    {
        // Ambil data user owner dari session
        $user = session('user');

        // Ambil data studio berdasarkan owner_uuid
        $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();

        if (!$studio) {
            return redirect()->route('home')->with('error', 'Studio tidak ditemukan.');
        }

        // Hitung total pendapatan studio
        $totalPendapatan = Pembayaran::where('studio_uuid', $studio->studio_uuid)
            ->where('payment_status', 1) // Asumsi: 1 = dibayar
            ->sum('payment_nominal');

        // Grafik pendapatan per bulan
        $pendapatanPeriode = Pembayaran::selectRaw("DATE_FORMAT(payment_date, '%Y-%m') as periode, SUM(payment_nominal) as total")
            ->where('studio_uuid', $studio->studio_uuid)
            ->where('payment_status', 1)
            ->groupBy('periode')
            ->get();
    
        // Ambil 3 kelas yoga terbaru
        $kelasBaru = KelasYoga::where('studio_uuid', $studio->studio_uuid)
            ->orderBy('kelas_name', 'desc') // Gantilah 'kelas_name' dengan kolom lain jika lebih relevan
            ->take(3)
            ->get();
        
        // Hitung total pendapatan studio
        $totalPendapatan = Pembayaran::where('studio_uuid', $studio->studio_uuid)
            ->where('payment_status', 1) // Status pembayaran valid
            ->sum('payment_nominal');
            

        return view('owner.dashboard.owner', [
            'title' => 'Dashboard Owner',
            'totalPendapatan' => $totalPendapatan,
            'pendapatanPeriode' => $pendapatanPeriode,
            'kelasBaru' => $kelasBaru,
        ]);
    }
}