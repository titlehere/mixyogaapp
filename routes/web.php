<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\StudioYogaController;
use App\Http\Controllers\KelasYogaController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route::get('/owner/dashboard', function () {
//     return view('owner/dashboard/owner'); // Gunakan slash (/) untuk folder
// })->name('owner.dashboard');

// Halaman Utama
Route::get('/', function () {
    return view('home');
})->name('home');

// Privacy Policy
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');

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

// Dashboard member
Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');

// Profile Member
Route::get('/member/profile', [MemberController::class, 'showProfile'])->name('member.profile');
Route::post('/member/profile/update', [MemberController::class, 'updateProfile'])->name('member.profile.update');

// Penyimpanan Kelas & Studio Member
Route::post('/save-studio/{studio_uuid}', [MemberController::class, 'saveStudio'])->name('save.studio');
Route::post('/save-class/{class_uuid}', [MemberController::class, 'saveClass'])->name('save.class');
Route::get('/member/simpan', [MemberController::class, 'showSavedItems'])->name('member.saved');

//FAQ Member
Route::get('/bantuan', function () {
    return view('member.dashboard.bantuan');
})->name('member.bantuan');

//Jelajah studio dan jelajah kelas member
Route::get('/jelajah/kelas', [KelasYogaController::class, 'exploreClasses'])->name('jelajah.kelas');
Route::get('/jelajah/studio', [StudioYogaController::class, 'exploreStudios'])->name('jelajah.studio');

//Dashboard Owner
Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');

// Profil dan Studio Owner
Route::get('/owner/profile-studio', [OwnerController::class, 'profileStudio'])->name('owner.profile_studio');
Route::post('/owner/profile-studio/update', [OwnerController::class, 'updateStudio'])->name('owner.update_studio');

// Kelola Kelas
Route::get('/owner/kelola-kelas', [KelasYogaController::class, 'index'])->name('owner.kelola_kelas');
Route::get('/owner/tambah-kelas', [KelasYogaController::class, 'createClass'])->name('owner.tambah_kelas');
Route::post('/owner/store-kelas', [KelasYogaController::class, 'storeClass'])->name('owner.store_kelas');
Route::get('/owner/kelas/{kelas_uuid}/edit', [KelasYogaController::class, 'edit'])->name('owner.edit_kelas');
Route::put('/owner/kelas/{kelas_uuid}', [KelasYogaController::class, 'update'])->name('owner.update_kelas');
Route::delete('/owner/kelas/{kelas_uuid}', [KelasYogaController::class, 'destroy'])->name('kelas.destroy');

// Kelola Jadwal Kelas
Route::get('/kelas/{kelas_uuid}/jadwal', [JadwalController::class, 'index'])->name('kelas.jadwal');
Route::get('/kelas/{kelas_uuid}/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
Route::post('/kelas/{kelas_uuid}/jadwal/store', [JadwalController::class, 'store'])->name('jadwal.store');
Route::get('/kelas/{kelas_uuid}/jadwal/{jadwal_uuid}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
Route::put('/kelas/{kelas_uuid}/jadwal/{jadwal_uuid}', [JadwalController::class, 'update'])->name('jadwal.update');
Route::delete('/kelas/{kelas_uuid}/jadwal/{jadwal_uuid}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

// Kelola Melihat Pesanan Kelas Oleh Member     
// Route::get('/kelas/{kelas_uuid}/member', [KelasYogaController::class, 'member'])->name('kelas.member');

// Profile Trainer
Route::middleware(['inject.studio'])->group(function () {
    Route::get('/owner/profile-trainer', [TrainerController::class, 'index'])->name('owner.profile_trainer');
    Route::get('/owner/tambah-trainer', [TrainerController::class, 'create'])->name('owner.tambah_trainer');
    Route::post('/owner/store-trainer', [TrainerController::class, 'store'])->name('owner.store_trainer');
    Route::get('/owner/trainer/{trainer_uuid}/edit', [TrainerController::class, 'edit'])->name('owner.edit_trainer');
    Route::put('/owner/trainer/{trainer_uuid}', [TrainerController::class, 'update'])->name('owner.update_trainer');
    Route::delete('/owner/trainer/{trainer_uuid}', [TrainerController::class, 'destroy'])->name('owner.destroy_trainer');
});

// Detail kelas yoga
Route::get('/kelas/{kelas_uuid}', [KelasYogaController::class, 'detail'])->name('kelas.detail');

// Detail studio yoga
Route::get('/studio/{studio_uuid}', [StudioYogaController::class, 'detail'])->name('studio.detail');

// Menampilkan semua trainer di studio tertentu
Route::get('/studio/{studio_uuid}/trainers', [StudioYogaController::class, 'trainers'])->name('studio.trainers');

// Menampilkan semua kelas di studio tertentu
Route::get('/studio/{studio_uuid}/classes', [StudioYogaController::class, 'classes'])->name('studio.classes');

//Navigasi kelas ke jadwal
Route::get('/kelas/{kelas_uuid}/jadwal', [KelasYogaController::class, 'jadwal'])->name('kelas.jadwal');

// Menampilkan jadwal kelas untuk member
Route::get('/kelas/{kelas_uuid}/jadwal/member', [JadwalController::class, 'showForMember'])->name('kelas.jadwal.member');

// Proses pemesanan jadwal kelas
Route::post('/kelas/{kelas_uuid}/jadwal/{jadwal_uuid}/pesan', [PemesananController::class, 'store'])->name('pemesanan.store');

// Menampilkan Riwayat Pemesanan Member
Route::get('/member/pesan', [PemesananController::class, 'showOrders'])->name('member.pesan');

// Proses pembatalan pemesanan
Route::put('/member/pesan/{booking_uuid}/cancel', [PemesananController::class, 'cancel'])->name('pemesanan.cancel');

// Proses menyelesaikan pembayaran
Route::put('/member/pesan/{booking_uuid}/complete', [PemesananController::class, 'complete'])->name('pemesanan.complete');

// Pembayaran
Route::get('/member/pesan/{booking_uuid}/pembayaran', [PembayaranController::class, 'showPaymentForm'])->name('pembayaran.form');
Route::post('/member/pesan/{booking_uuid}/pembayaran', [PembayaranController::class, 'processPayment'])->name('pembayaran.process');

// Review dari Member
Route::get('/member/pesan/{booking_uuid}/review', [ReviewController::class, 'showReviewForm'])->name('review.form');
Route::post('/member/pesan/{booking_uuid}/review', [ReviewController::class, 'submitReview'])->name('review.submit');

// Halaman Laporan bagi Owner
Route::get('/owner/laporan', [OwnerController::class, 'laporan'])->name('owner.laporan');

// Bantuan & FAQ
Route::get('/owner/bantuan-faq', [OwnerController::class, 'bantuanFaq'])->name('owner.bantuan_faq');

// Route untuk melihat daftar member yang memesan jadwal
Route::get('/kelas/{kelas_uuid}/jadwal/{jadwal_uuid}/member-pesan', [JadwalController::class, 'memberPesan'])
    ->name('jadwal.member.pesan');

// Route untuk melihat daftar review dan rating member pada jadwal
Route::get('/kelas/{kelas_uuid}/jadwal/{jadwal_uuid}/member-review', [JadwalController::class, 'memberReview'])
    ->name('jadwal.member.review');