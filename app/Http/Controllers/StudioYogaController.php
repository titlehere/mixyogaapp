<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Review;
use App\Models\StudioYoga;
use Illuminate\Http\Request;

class StudioYogaController extends Controller
{
    // Menampilkan data studio yoga yang disimpan
    public function index(Request $request)
    {
        $search = $request->input('search');
        $studios = StudioYoga::when($search, function ($query, $search) {
            return $query->where('studio_name', 'like', "%$search%")
                ->orWhere('studio_lokasi', 'like', "%$search%");
        })->get();

        return view('jelajah.studio', compact('studios', 'search'));
    }

    // Mengambil studio yoga berdasarkan ID
    public function show($id)
    {
        $studio = StudioYoga::findOrFail($id);
        return view('studio.show', compact('studio'));
    }

    //Menampilkan jelajah studio dari studio yang tertera
    public function exploreStudios(Request $request)
    {
        $search = $request->input('search');
        $studios = StudioYoga::where('studio_name', 'like', '%' . $search . '%')->get();

        return view('member.jelajah.studio', [
            'title' => 'Jelajah Studio',
            'studios' => $studios,
            'search' => $search,
        ]);
    }

    //Menampilkan detail studio di dashbaord member
    public function detail($studio_uuid)
{
    $studio = StudioYoga::with(['owner', 'classes.jadwals'])->where('studio_uuid', $studio_uuid)->firstOrFail();

    foreach ($studio->classes as $kelas) {
        $kelas->hasActiveJadwal = $kelas->jadwals->contains(function ($jadwal) {
            return $jadwal->jadwal_status === 'Belum Mulai';
        });
    }

    // Hitung rating rata-rata dan ulasan total
    $jadwalUuids = $studio->classes->flatMap(function ($kelas) {
        return $kelas->jadwals->pluck('jadwal_uuid');
    });

    $averageRating = Review::whereIn('jadwal_uuid', $jadwalUuids)->avg('review_rating');
    $totalReviews = Review::whereIn('jadwal_uuid', $jadwalUuids)->count();

    return view('member.studio.detail', [
        'studio' => $studio,
        'averageRating' => $averageRating,
        'totalReviews' => $totalReviews,
    ]);
}

// Menampilkan daftar trainer untuk studio tertentu
    public function trainers($studio_uuid)
    {
        $studio = StudioYoga::findOrFail($studio_uuid);
        $trainers = Trainer::where('studio_uuid', $studio_uuid)->get();

        return view('member.studio.trainers', [
            'title' => 'Daftar Trainer di ' . $studio->studio_name,
            'studio' => $studio,
            'trainers' => $trainers,
        ]);
    }

    public function classes($studio_uuid)
    {
        $studio = StudioYoga::with('classes.jadwals')->findOrFail($studio_uuid);
    
        // Periksa apakah ada jadwal aktif untuk setiap kelas
        foreach ($studio->classes as $kelas) {
            $kelas->hasActiveJadwal = $kelas->jadwals->contains(function ($jadwal) {
                return $jadwal->jadwal_status === 'Belum Mulai';
            });
        }
    
        return view('member.studio.classes', [
            'title' => 'Daftar Kelas Studio',
            'studio' => $studio,
            'classes' => $studio->classes, // Mengirimkan data kelas dengan properti tambahan
        ]);
    }    

    public function simpanStudio($studio_uuid)
    {
        $user = session('user');

        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Cek apakah studio sudah disimpan
        $member = \App\Models\Member::find($user->member_uuid);
        $studio = StudioYoga::findOrFail($studio_uuid);

        if ($member->savedStudios()->where('studio_uuid', $studio_uuid)->exists()) {
            return back()->with('error', 'Studio sudah ada di daftar simpan Anda.');
        }

        // Simpan studio
        $member->savedStudios()->attach($studio_uuid);

        return back()->with('success', 'Studio berhasil disimpan.');
    }
}