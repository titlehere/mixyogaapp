<?php

namespace App\Http\Controllers;

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
}