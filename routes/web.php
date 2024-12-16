<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\StudioYogaController;
use App\Http\Controllers\KelasYogaController;
use App\Http\Controllers\OwnerController;

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

//Logout
Route::get('/logout', function () {
    session()->flush(); // Menghapus semua session
    return redirect()->route('home')->with('success', 'Anda berhasil logout.');
})->name('logout');

// Profile Member
Route::get('/member/profile', [MemberController::class, 'showProfile'])->name('member.profile');
Route::post('/member/profile/update', [MemberController::class, 'updateProfile'])->name('member.profile.update');

// Pemesanan Member
Route::get('/member/pesan', [PesanController::class, 'showOrders'])->name('member.pesan');

// Penyimpanan Kelas & Studio Member
Route::get('/member/simpan', [MemberController::class, 'showSavedItems'])->name('member.saved');

//FAQ Member
Route::get('/bantuan', function () {
    return view('member.dashboard.bantuan');
})->name('member.bantuan');

//Jelajah studio dan jelajah kelas member
Route::get('/jelajah/studio', [StudioYogaController::class, 'exploreStudios'])->name('jelajah.studio');
Route::get('/jelajah/kelas', [KelasYogaController::class, 'exploreClasses'])->name('jelajah.kelas');

//Dashboard Owner
giRoute::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');