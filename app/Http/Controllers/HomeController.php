<?php

namespace App\Http\Controllers;

use App\Models\StudioYoga;
use App\Models\KelasYoga;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data studio dan kelas yoga
        $studios = StudioYoga::take(5)->get();
        $classes = KelasYoga::take(5)->get();

        // Kirim data ke home.blade.php
        return view('home', [
            'studios' => $studios,
            'classes' => $classes,
        ]);
    }
}
