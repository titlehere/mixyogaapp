<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Models\OwnerStudio;

class LoginController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Cek Login untuk Member
        $member = Member::where('member_email', $request->email)->first();
        if ($member && Hash::check($request->password, $member->member_pass)) {
            // Set session untuk Member
            session(['user' => $member, 'role' => 'member']);
            return redirect()->route('member.dashboard')->with('success', 'Login berhasil sebagai Member!');
        }

        // Cek Login untuk Owner
        $owner = OwnerStudio::where('owner_email', $request->email)->first();
        if ($owner && Hash::check($request->password, $owner->owner_pass)) {
            // Set session untuk Owner
            session(['user' => $owner, 'role' => 'owner']);
            return redirect()->route('owner.dashboard')->with('success', 'Login berhasil sebagai Owner!');
        }

        // Jika tidak ada data yang cocok
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }
}