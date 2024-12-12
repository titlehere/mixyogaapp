<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\OwnerStudio;
use App\Models\StudioYoga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function registerMember(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:member,member_email'],
            'phone' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'password' => ['required', 'string', 'min:5', 'max:12'],
            'password_confirmation' => ['required', 'same:password'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Membuat Member baru
            Member::create([
                'member_uuid' => Str::uuid(),
                'member_name' => $request->username,
                'member_email' => $request->email,
                'member_pass' => Hash::make($request->password),
                'member_phone' => $request->phone,
                'member_status' => true,
            ]);

            return redirect()->route('home')->with('success', 'Pendaftaran Member berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.')->withInput();
        }
    }

    public function registerOwner(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', 'unique:owner_studio,owner_email'],
            'phone' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'password' => ['required', 'string', 'min:5', 'max:12'],
            'password_confirmation' => ['required', 'same:password'],
            'studio_name' => ['required', 'string', 'max:255'],
            'studio_address' => ['required', 'string', 'max:255'],
            'studio_logo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Membuat Owner baru
            $owner = OwnerStudio::create([
                'owner_uuid' => Str::uuid(),
                'owner_name' => $request->username,
                'owner_email' => $request->email,
                'owner_pass' => Hash::make($request->password),
                'owner_phone' => $request->phone,
                'owner_status' => true,
            ]);

            // Upload logo studio
            $logoPath = $request->file('studio_logo')->store('studio_logos', 'public');

            // Membuat Studio baru
            StudioYoga::create([
                'studio_uuid' => Str::uuid(),
                'owner_uuid' => $owner->owner_uuid,
                'studio_name' => $request->studio_name,
                'studio_desk' => '',
                'studio_lokasi' => $request->studio_address,
                'studio_logo' => $logoPath,
            ]);

            return redirect()->route('home')->with('success', 'Pendaftaran Owner dan Studio berhasil!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan, silakan coba lagi.')->withInput();
        }
    }
}