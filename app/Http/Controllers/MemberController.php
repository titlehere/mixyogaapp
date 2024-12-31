<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PesanController;
use App\Models\Member;
use App\Models\Review;
use App\Models\StudioYoga;
use App\Models\KelasYoga;

class MemberController extends Controller
{
    // Menampilkan halaman profil
    public function showProfile()
    {
        $user = session('user');
        $reviews = Review::where('member_uuid', $user->member_uuid)->get();

        return view('member.dashboard.profile', [
            'title' => 'Profil Saya',
            'user' => $user,
            'reviews' => $reviews
        ]);
    }

    // Mengupdate profil member
    public function updateProfile(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'member_name'   => ['required', 'string', 'max:255'],
            'member_email'  => ['required', 'email', 'unique:member,member_email,' . session('user')->member_uuid . ',member_uuid'],
            'member_phone'  => ['required', 'regex:/^(\+62|0)[2-9][0-9]{7,12}$/'],
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Ambil data user dari session
        $user = Member::findOrFail(session('user')->member_uuid);

        // Upload gambar baru jika ada
        if ($request->hasFile('profile_photo')) {
            $filename = time() . '.' . $request->file('profile_photo')->getClientOriginalExtension();
            $request->file('profile_photo')->move(public_path('images/profiles'), $filename);
            $user->profile_photo = $filename; // Update nama gambar
        }

        // Update data user
        $user->update([
            'member_name'  => $validatedData['member_name'],
            'member_email' => $validatedData['member_email'],
            'member_phone' => $validatedData['member_phone'],
            'profile_photo' => $user->profile_photo, // Tetap simpan nama file lama jika tidak diupdate
        ]);

        // Update session
        session(['user' => $user]);

        return redirect()->route('member.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    //Menampilkan kelas dalam pemesanan
    public function showOrders()
    {
        $pesanController = new PesanController();
        return $pesanController->showOrders();
    }

    public function saveStudio(Request $request, $studio_uuid)
    {
        $user = session('user');
        $member = Member::findOrFail($user->member_uuid);

        $savedStudios = $member->saved_studios ?? [];
        if (!in_array($studio_uuid, $savedStudios)) {
            $savedStudios[] = $studio_uuid;
            $member->saved_studios = $savedStudios;
            $member->save();
        }

        return redirect()->back()->with('success', 'Studio berhasil disimpan!');
    }

    public function saveClass(Request $request, $class_uuid)
    {
        $user = session('user');
        $member = Member::findOrFail($user->member_uuid);

        $savedClasses = $member->saved_classes ?? [];
        if (!in_array($class_uuid, $savedClasses)) {
            $savedClasses[] = $class_uuid;
            $member->saved_classes = $savedClasses;
            $member->save();
        }

        return redirect()->back()->with('success', 'Kelas berhasil disimpan!');
    }

    public function showSavedItems()
    {
        $user = session('user');
        $member = Member::findOrFail($user->member_uuid);

        $savedClasses = KelasYoga::whereIn('kelas_uuid', $member->saved_classes ?? [])->get();
        $savedStudios = StudioYoga::whereIn('studio_uuid', $member->saved_studios ?? [])->get();

        return view('member.dashboard.simpan', [
            'savedKelas' => $savedClasses,
            'savedStudios' => $savedStudios,
        ]);
    }

    public function dashboard(Request $request)
    {
        $search = $request->input('search');

        // Mengambil kelas yoga terbaru
        $latestClasses = KelasYoga::when($search, function ($query, $search) {
            $query->where('kelas_name', 'like', "%$search%")
                ->orWhereHas('studio', function ($query) use ($search) {
                    $query->where('studio_name', 'like', "%$search%");
                });
        })->orderBy('kelas_uuid', 'desc') // Ganti 'kelas_uuid' dengan kolom pengurutan yang relevan
        ->take(5)
        ->get();

        // Mengambil studio yoga terbaru
        $latestStudios = StudioYoga::when($search, function ($query, $search) {
            $query->where('studio_name', 'like', "%$search%")
                ->orWhere('studio_lokasi', 'like', "%$search%");
        })->orderBy('studio_uuid', 'desc') // Ganti 'studio_uuid' dengan kolom pengurutan yang relevan
        ->take(5)
        ->get();

        return view('member.dashboard.member', [
            'title' => 'Dashboard Member',
            'latestClasses' => $latestClasses,
            'latestStudios' => $latestStudios,
            'search' => $search,
        ]);
    }
}