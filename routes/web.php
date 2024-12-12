<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', function () {
    return view('home');
})->name('home');

// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');

// Dashboard Berdasarkan Role
Route::get('/member/dashboard', function () {
    return view('member/dashboard/member'); // Gunakan slash (/) untuk folder
})->name('member.dashboard');

Route::get('/owner/dashboard', function () {
    return view('owner/dashboard/owner'); // Gunakan slash (/) untuk folder
})->name('owner.dashboard');

// Registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register/member', [RegisterController::class, 'registerMember'])->name('register.member');
Route::post('/register/owner', [RegisterController::class, 'registerOwner'])->name('register.owner');

// Login
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);