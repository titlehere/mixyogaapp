<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Review;
use App\Models\StudioYoga;
use App\Models\KelasYoga;

class MemberController extends Controller
{
    // Menampilkan halaman profil
    public function showProfile()
    {
        // Ambil data user dari session
        $user = session('user');
        
        // Validasi jika session user kosong atau tidak memiliki properti member_uuid
        if (!$user || !isset($user->member_uuid)) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil review berdasarkan member_uuid
        $reviews = Review::where('member_uuid', $user->member_uuid)->get();
    
        // Kirim data ke view
        return view('member.dashboard.profile', [
            'title' => 'Profil Saya',
            'user' => $user,
            'reviews' => $reviews,
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
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Bersifat opsional
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
        ]);

        // Update session
        session(['user' => $user]);

        return redirect()->route('member.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    //Menampilkan kelas dalam pemesanan
    // public function showOrders()
    // {
    //     $pesanController = new PesanController();
    //     return $pesanController->showOrders();
    // }

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
        // Ambil data user dari session
        $user = session('user');
    
        // Validasi apakah user tersedia dan memiliki member_uuid
        if (!$user || !isset($user->member_uuid)) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data member berdasarkan member_uuid
        $member = Member::find($user->member_uuid);
    
        // Jika member tidak ditemukan, redirect dengan pesan error
        if (!$member) {
            return redirect()->back()->with('error', 'Member tidak ditemukan.');
        }
    
        // Ambil data kelas dan studio yang disimpan
        $savedClasses = KelasYoga::whereIn('kelas_uuid', $member->saved_classes ?? [])->get();
        $savedStudios = StudioYoga::whereIn('studio_uuid', $member->saved_studios ?? [])->get();
    
        // Kirim data ke view
        return view('member.dashboard.simpan', [
            'savedKelas' => $savedClasses,
            'savedStudios' => $savedStudios,
        ]);
    }    

    public function dashboard(Request $request)
    {
        $search = $request->input('search');

        // Mengambil kelas yoga terbaru dengan rating rata-rata dan jumlah ulasan
        $latestClasses = KelasYoga::with(['studio'])
            ->withAvg('reviews as averageRating', 'review_rating') // Menghitung rata-rata rating
            ->withCount('reviews') // Menghitung jumlah ulasan
            ->when($search, function ($query, $search) {
                $query->where('kelas_name', 'like', "%$search%")
                    ->orWhereHas('studio', function ($query) use ($search) {
                        $query->where('studio_name', 'like', "%$search%");
                    });
            })
            ->orderBy('kelas_uuid', 'desc') // Urutkan berdasarkan kelas terbaru
            ->take(5)
            ->get();

        // Mengambil studio yoga terbaru
        $latestStudios = StudioYoga::when($search, function ($query, $search) {
            $query->where('studio_name', 'like', "%$search%")
                ->orWhere('studio_lokasi', 'like', "%$search%");
        })
            ->orderBy('studio_uuid', 'desc') // Urutkan berdasarkan studio terbaru
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