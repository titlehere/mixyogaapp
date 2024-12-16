<?php

namespace App\Http\Controllers;

use App\Models\KelasYoga;
use Illuminate\Http\Request;

class KelasYogaController extends Controller
{
    // Menampilkan data kelas yoga yang disimpan
    public function index(Request $request)
    {
        $search = $request->input('search');
        $classes = KelasYoga::when($search, function ($query, $search) {
            return $query->where('kelas_name', 'like', "%$search%");
        })->get();

        return view('jelajah.kelas', compact('classes', 'search'));
    }

    // Mengambil kelas yoga berdasarkan ID
    public function show($id)
    {
        $kelas = KelasYoga::findOrFail($id);
        return view('kelas.show', compact('kelas'));
    }

    public function exploreClasses(Request $request)
    {
        $search = $request->input('search');
        $classes = KelasYoga::where('kelas_name', 'like', '%' . $search . '%')->get();

        return view('member.jelajah.kelas', [
            'title' => 'Jelajah Kelas',
            'classes' => $classes,
            'search' => $search,
        ]);
    }
}
