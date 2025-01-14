<?php

namespace App\Http\Controllers;

use App\Models\KelasYoga;
use App\Models\StudioYoga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KelasYogaController extends Controller
{
    // Menampilkan halaman Kelola Kelas
public function index()
{
    $user = session('user');
    
    // Periksa apakah session 'user' ada dan memiliki properti owner_uuid
    if (!$user || !isset($user->owner_uuid)) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    // Ambil data studio berdasarkan owner_uuid
    $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();
    
    // Periksa apakah studio ditemukan
    if (!$studio) {
        return redirect()->route('owner.profile_studio')->with('error', 'Studio tidak ditemukan.');
    }
    
    // Ambil semua kelas yoga terkait studio
    $classes = KelasYoga::with('jadwals') // Tambahkan relasi jadwals jika dibutuhkan
        ->where('studio_uuid', $studio->studio_uuid)
        ->get();
    
    return view('owner.dashboard.kelola_kelas', [
        'title' => 'Kelola Kelas',
        'studio' => $studio,
        'classes' => $classes,
    ]);
}

    public function exploreClasses(Request $request)
    {
        $search = $request->input('search');
    
        // Query kelas berdasarkan pencarian
        $classes = KelasYoga::with('studio') // Relasi ke studio
            ->when($search, function ($query, $search) {
                return $query->where('kelas_name', 'like', '%' . $search . '%')
                    ->orWhereHas('studio', function ($query) use ($search) {
                        $query->where('studio_name', 'like', '%' . $search . '%')
                            ->orWhere('studio_lokasi', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('kelas_uuid', 'desc') // Urutkan berdasarkan UUID
            ->paginate(10); // Batasi jumlah per halaman
    
        return view('member.jelajah.kelas', [
            'title' => 'Jelajah Kelas Yoga',
            'classes' => $classes,
            'search' => $search,
        ]);
    }    

    // Menampilkan halaman Tambah Kelas
    public function createClass()
    {
        $user = session('user');
        $studio = StudioYoga::where('owner_uuid', $user->owner_uuid)->first();

        return view('owner.dashboard.tambah_kelas', [ // Lokasi diperbarui
            'title' => 'Tambah Kelas Yoga',
            'studio' => $studio,
        ]);
    }

    // Menyimpan data kelas baru
    public function storeClass(Request $request)
    {
        $validatedData = $request->validate([
            'kelas_name' => ['required', 'string', 'max:255'],
            'kelas_desk' => ['nullable', 'string', 'max:500'],
            'kelas_kapasitas' => ['required', 'integer'],
            'kelas_harga' => ['required', 'numeric'],
            'kelas_thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $validatedData['kelas_uuid'] = (string) Str::uuid();
        $validatedData['studio_uuid'] = $request->studio_uuid;

        if ($request->hasFile('kelas_thumbnail')) {
            $file = $request->file('kelas_thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/kelas_thumbnails'), $filename);
            $validatedData['kelas_thumbnail'] = $filename;
        }

        KelasYoga::create($validatedData);

        return redirect()->route('owner.kelola_kelas')->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    // Menampilkan halaman Edit Kelas
    // Menampilkan halaman Edit Kelas
    public function edit($kelas_uuid)
    {
        $kelas = KelasYoga::findOrFail($kelas_uuid);

        return view('owner.dashboard.edit_kelas', [ // Lokasi diperbarui
            'title' => 'Edit Kelas',
            'kelas' => $kelas,
        ]);
    }

    // Memperbarui data kelas
    public function update(Request $request, $kelas_uuid)
    {
        $validatedData = $request->validate([
            'kelas_name' => ['required', 'string', 'max:255'],
            'kelas_desk' => ['nullable', 'string', 'max:500'],
            'kelas_kapasitas' => ['required', 'integer'],
            'kelas_harga' => ['required', 'numeric'],
            'kelas_thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $kelas = KelasYoga::findOrFail($kelas_uuid);

        if ($request->hasFile('kelas_thumbnail')) {
            $file = $request->file('kelas_thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/kelas_thumbnails'), $filename);

            if ($kelas->kelas_thumbnail && file_exists(public_path('images/kelas_thumbnails/' . $kelas->kelas_thumbnail))) {
                unlink(public_path('images/kelas_thumbnails/' . $kelas->kelas_thumbnail));
            }

            $validatedData['kelas_thumbnail'] = $filename;
        }

        $kelas->update($validatedData);

        return redirect()->route('owner.kelola_kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    // Menghapus kelas
    public function destroy($kelas_uuid)
    {
        $kelas = KelasYoga::findOrFail($kelas_uuid);

        if ($kelas->kelas_thumbnail && file_exists(public_path('public/mages/kelas_thumbnails/' . $kelas->kelas_thumbnail))) {
            unlink(public_path('images/kelas_thumbnails/' . $kelas->kelas_thumbnail));
        }

        $kelas->delete();

        return redirect()->route('owner.kelola_kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    // Menampilkan jadwal kelas
    public function jadwal($kelas_uuid)
{
    // Ambil data kelas
    $kelas = KelasYoga::findOrFail($kelas_uuid);

    // Ambil jadwal yang terkait dengan kelas ini
    $jadwals = $kelas->jadwals()->with('trainer')->get();

    return view('owner.dashboard.jadwal', [
        'title' => 'Jadwal Kelas Yoga',
        'kelas' => $kelas,
        'jadwals' => $jadwals,
    ]);
}

    // Menampilkan daftar member yang memesan kelas
    public function member($kelas_uuid)
    {
        // Logika untuk menampilkan member yang memesan kelas
        return view('kelas.member', ['kelas_uuid' => $kelas_uuid]);
    }

// KelasYogaController.php
    public function detail($kelas_uuid)
    {
        $kelas = KelasYoga::with('studio', 'reviews')->findOrFail($kelas_uuid);

        // Hitung rata-rata rating dan total ulasan
        $averageRating = $kelas->reviews()->avg('review_rating');
        $totalReviews = $kelas->reviews()->count();

        return view('member.kelas.detail', [
            'title' => 'Detail Kelas Yoga',
            'kelas' => $kelas,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
        ]);
    }    
}