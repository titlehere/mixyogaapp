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
// Menampilkan detail studio di dashboard member
    public function detail($studio_uuid)
    {
        // Ambil data studio berdasarkan UUID
        $studio = StudioYoga::with(['owner', 'classes'])->where('studio_uuid', $studio_uuid)->firstOrFail();

        // Hitung rata-rata rating dan total ulasan berdasarkan jadwal yang terkait dengan studio
        $jadwalUuids = $studio->classes->flatMap(function ($kelas) {
            return $kelas->jadwals->pluck('jadwal_uuid');
        });

        $averageRating = Review::whereIn('jadwal_uuid', $jadwalUuids)->avg('review_rating');
        $totalReviews = Review::whereIn('jadwal_uuid', $jadwalUuids)->count();

        // Kirim data ke view
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
        $studio = StudioYoga::with('classes')->findOrFail($studio_uuid);

        return view('member.studio.classes', [
            'title' => 'Daftar Kelas Studio',
            'studio' => $studio,
            'classes' => $studio->classes, // Asumsi relasi classes telah didefinisikan
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