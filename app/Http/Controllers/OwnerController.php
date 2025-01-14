<?php

namespace App\Http\Controllers;

use App\Models\StudioYoga;
use App\Models\KelasYoga;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\OwnerStudio;
use App\Models\Review;

class OwnerController extends Controller
{
    public function dashboard()
    {
        // Ambil data user owner dari session
        $user = session('user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data studio berdasarkan owner_uuid
        $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();

        if (!$studio) {
            return redirect()->route('owner.profile_studio')->with('error', 'Studio tidak ditemukan. Silakan lengkapi profil studio Anda.');
        }

        // Total pendapatan hanya untuk studio yang dimiliki oleh owner
        $totalPendapatan = Pembayaran::where('studio_uuid', $studio->studio_uuid)
            ->where('payment_status', 'Paid')
            ->sum('payment_nominal');

        // Data untuk grafik pendapatan per bulan (hanya untuk studio yang dimiliki)
        $pendapatanPeriode = Pembayaran::selectRaw("DATE_FORMAT(payment_date, '%Y-%m') as periode, SUM(payment_nominal) as total")
            ->where('studio_uuid', $studio->studio_uuid)
            ->where('payment_status', 'Paid')
            ->groupBy('periode')
            ->orderBy('periode', 'asc')
            ->get();

        // Hitung total rating dan rata-rata review untuk studio
        $totalRating = Review::whereHas('jadwal.kelas', function ($query) use ($studio) {
            $query->where('studio_uuid', $studio->studio_uuid);
        })->sum('review_rating');

        $totalReviews = Review::whereHas('jadwal.kelas', function ($query) use ($studio) {
            $query->where('studio_uuid', $studio->studio_uuid);
        })->count();

        $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;

        // Ambil 3 kelas yoga terbaru berdasarkan kolom yang ada, misalnya `kelas_name`
        $kelasBaru = KelasYoga::where('studio_uuid', $studio->studio_uuid)
            ->orderBy('kelas_uuid', 'desc') // Gunakan kolom `kelas_uuid` untuk pengurutan
            ->take(3)
            ->get();

        return view('owner.dashboard.owner', [
            'title' => 'Dashboard Owner',
            'studio' => $studio,
            'totalPendapatan' => $totalPendapatan,
            'pendapatanPeriode' => $pendapatanPeriode,
            'totalRating' => $totalRating,
            'averageRating' => $averageRating,
            'kelasBaru' => $kelasBaru,
        ]);
    }

    public function updateOwner(Request $request)
    {
        $request->validate([
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'owner_phone' => 'required|regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/',
        ]);

        $user = session('user');
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $owner = OwnerStudio::findOrFail($user->owner_uuid);
        $owner->update($request->only('owner_name', 'owner_email', 'owner_phone'));

        session(['user' => $owner]);

        return redirect()->route('owner.profile_studio')->with('success', 'Profil berhasil diperbarui.');
    }    

    // Menampilkan halaman Profil dan Studio
    public function profileStudio()
    {
        $user = session('user'); // Ambil user dari session
        if (!$user || !isset($user->owner_uuid)) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first(); // Cari studio berdasarkan owner
    
        if (!$studio) {
            return redirect()->route('owner.dashboard')->with('error', 'Data studio tidak ditemukan.');
        }

        return view('owner.dashboard.profile_studio', [
            'title' => 'Profil dan Studio',
            'studio' => $studio,
            'user' => $user
        ]);
    }

    // Memperbarui data studio
    public function updateStudio(Request $request)
    {
        $validatedData = $request->validate([
            'owner_name'   => ['required', 'string', 'max:255'],
            'owner_email'  => ['required', 'email', 'unique:owner_studio,owner_email,' . session('user')->owner_uuid . ',owner_uuid'],
            'owner_phone'  => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'studio_name'  => ['required', 'string', 'max:255'],
            'studio_lokasi'=> ['required', 'string', 'max:255'],
            'studio_desk'  => ['nullable', 'string', 'max:500'],
            'studio_logo'  => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);        

        $user = session('user');
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Update Owner
        $owner = OwnerStudio::findOrFail($user->owner_uuid);
        $owner->update($request->only('owner_name', 'owner_email', 'owner_phone'));

        // Update Studio
        $studio = StudioYoga::where('owner_uuid', $owner->owner_uuid)->first();
        if (!$studio) {
            return redirect()->route('owner.profile_studio')->with('error', 'Data studio tidak ditemukan.');
        }

        if ($request->hasFile('studio_logo')) {
            $file = $request->file('studio_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/studio_logos'), $filename);

            if ($studio->studio_logo && file_exists(public_path('images/studio_logos/' . $studio->studio_logo))) {
                unlink(public_path('images/studio_logos/' . $studio->studio_logo));
            }

            $studio->studio_logo = $filename;
        }

        $studio->update($request->only('studio_name', 'studio_lokasi', 'studio_desk'));

        // Update Session
        session(['user' => $owner]);

        return redirect()->route('owner.profile_studio')->with('success', 'Profil dan data studio berhasil diperbarui.');
    }

    public function laporan()
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();
        if (!$studio) {
            return redirect()->route('owner.profile_studio')->with('error', 'Studio tidak ditemukan.');
        }

        // Data laporan
        $laporanPeriode = Pembayaran::laporanPeriode($studio->studio_uuid);

        $pendapatanPerKelas = KelasYoga::where('studio_uuid', $studio->studio_uuid)
            ->with(['jadwals' => function ($query) {
                $query->withSum('pembayarans', 'payment_nominal');
            }])
            ->get();

        // Ambil data review dari member berdasarkan studio
        $reviews = Review::with(['jadwal.kelas', 'member'])
            ->whereHas('jadwal.kelas', function ($query) use ($studio) {
                $query->where('studio_uuid', $studio->studio_uuid);
            })
            ->orderBy('review_date', 'desc') // Gunakan review_date
            ->get();    

        return view('owner.dashboard.laporan', [
            'title' => 'Laporan Studio',
            'studio' => $studio,
            'laporanPeriode' => $laporanPeriode,
            'pendapatanPerKelas' => $pendapatanPerKelas,
            'reviews' => $reviews, // Tambahkan data review
        ]);
    }

    public function cetakLaporan()
    {
        $user = session('user');
    
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();
        if (!$studio) {
            return redirect()->route('owner.profile_studio')->with('error', 'Studio tidak ditemukan.');
        }
    
        // Data laporan periode
        $laporanPeriode = Pembayaran::where('studio_uuid', $studio->studio_uuid)
            ->selectRaw('DATE_FORMAT(payment_date, "%Y-%m") as periode, SUM(payment_nominal) as total_pendapatan, COUNT(*) as jumlah_transaksi')
            ->groupBy('periode')
            ->get();
    
        // Pendapatan per kelas
        $pendapatanPerKelas = KelasYoga::where('studio_uuid', $studio->studio_uuid)
            ->with(['jadwals' => function ($query) {
                $query->withSum('pembayarans', 'payment_nominal');
            }])
            ->get();
    
        // Review dan rating member
        $reviews = Review::with(['jadwal.kelas', 'member'])
            ->whereHas('jadwal.kelas', function ($query) use ($studio) {
                $query->where('studio_uuid', $studio->studio_uuid);
            })
            ->orderBy('review_date', 'desc')
            ->get();
    
        return view('owner.laporan.cetak', [
            'title' => 'Cetak Laporan Studio',
            'studio' => $studio,
            'laporanPeriode' => $laporanPeriode,
            'pendapatanPerKelas' => $pendapatanPerKelas,
            'reviews' => $reviews,
        ]);
    }    

    public function bantuanFaq()
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();

        return view('owner.dashboard.bantuan_faq', [
            'title' => 'Bantuan & FAQ',
            'studio' => $studio,
        ]);
    }
}