<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\OwnerStudio;
use App\Models\StudioYoga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller 
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Proses registrasi member
    public function registerMember(Request $request)
    {
        // Validasi input dengan pesan kustom
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'unique:member,member_email'],
            'phone'    => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'password' => ['required', 'string', 'min:5', 'max:12', 'confirmed'],
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'phone.required'    => 'Nomor telepon wajib diisi.',
            'phone.regex'       => 'Format nomor telepon tidak valid. Contoh: 081234567890.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 5 karakter.',
            'password.max'      => 'Password maksimal 12 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak sesuai.',
            'profile_photo.required' => 'Foto profil wajib diunggah.',
            'profile_photo.image'    => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes'    => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'profile_photo.max'      => 'Ukuran gambar maksimal 2 MB.',
        ]);

        // Upload gambar profil jika ada
        $filename = null;
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName(); // Nama file unik
            $file->move(public_path('images/profiles'), $filename);   // Simpan file
        }

        // Simpan data ke database
        $member = Member::create([
            'member_uuid'   => Str::uuid(),
            'member_name'   => $validatedData['username'],
            'member_email'  => $validatedData['email'],
            'member_pass'   => Hash::make($validatedData['password']),
            'member_phone'  => $validatedData['phone'],
            'profile_photo' => $filename, // Nama file gambar
            'member_status' => true,
        ]);

        // Simpan sesi user
        session(['user' => $member]);

        // Arahkan ke dashboard member
        return redirect()->route('member.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Mix Yoga.');
    }

    // Proses registrasi owner studio
    public function registerOwner(Request $request)
    {
        // Validasi input dengan pesan kustom
        $validatedData = $request->validate([
            'username'             => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', 'unique:owner_studio,owner_email'],
            'phone'                => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'password'             => ['required', 'string', 'min:5', 'max:12', 'confirmed'],
            'studio_name'          => ['required', 'string', 'max:255'],
            'studio_address'       => ['required', 'string', 'max:255'],
            'studio_logo'          => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'username.required'     => 'Nama pengguna wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'phone.required'        => 'Nomor telepon wajib diisi.',
            'phone.regex'           => 'Format nomor telepon tidak valid. Contoh: 081234567890.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 5 karakter.',
            'password.max'          => 'Password maksimal 12 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak sesuai.',
            'studio_name.required'  => 'Nama studio wajib diisi.',
            'studio_address.required' => 'Alamat studio wajib diisi.',
            'studio_logo.required'  => 'Logo studio wajib diunggah.',
            'studio_logo.image'     => 'Logo studio harus berupa gambar.',
            'studio_logo.mimes'     => 'Format gambar hanya boleh jpg, jpeg, atau png.',
            'studio_logo.max'       => 'Ukuran gambar maksimal 2 MB.',
        ]);

        try {
            // Simpan data owner studio
            $owner = OwnerStudio::create([
                'owner_uuid'   => Str::uuid(),
                'owner_name'   => $validatedData['username'],
                'owner_email'  => $validatedData['email'],
                'owner_pass'   => Hash::make($validatedData['password']),
                'owner_phone'  => $validatedData['phone'],
                'owner_status' => true,
            ]);

            // Upload logo studio
            $logoFile = $request->file('studio_logo');
            $logoName = time() . '_' . $logoFile->getClientOriginalName();
            $logoFile->move(public_path('images/studio_logos'), $logoName);

            // Simpan data studio yoga
            StudioYoga::create([
                'studio_uuid'   => Str::uuid(),
                'owner_uuid'    => $owner->owner_uuid,
                'studio_name'   => $validatedData['studio_name'],
                'studio_desk'   => '',
                'studio_lokasi' => $validatedData['studio_address'],
                'studio_logo'   => $logoName, // Nama file logo
            ]);

            // Simpan sesi user
            session(['user' => $owner]);

            // Arahkan ke dashboard owner
            return redirect()->route('owner.dashboard')->with('success', 'Registrasi Owner Studio berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.')->withInput();
        }
    }
}