<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrainerController extends Controller
{
    public function index()
    {
        // Ambil studio dari sesi pengguna yang disediakan oleh middleware
        $studio = session('studio');

        if (!$studio) {
            return redirect()->route('owner.dashboard')->with('error', 'Studio tidak ditemukan.');
        }

        $trainers = Trainer::where('studio_uuid', $studio->studio_uuid)->get();

        return view('owner.dashboard.profile_trainer', [
            'title' => 'Data Trainer Studio Yoga',
            'trainers' => $trainers,
        ]);
    }
    
    public function create()
    {
        return view('owner.dashboard.tambah_trainer', [
            'title' => 'Tambah Trainer Baru',
        ]);
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'trainer_name' => ['required', 'string', 'max:255'],
        'trainer_desk' => ['nullable', 'string', 'max:500'],
        'trainer_umur' => ['required', 'integer'],
        'trainer_sertif' => ['nullable', 'string'],
        'trainer_link_fb' => ['nullable', 'url'],
        'trainer_link_ig' => ['nullable', 'url'],
        'trainer_link_tw' => ['nullable', 'url'],
        'trainer_foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
    ]);

    $validatedData['trainer_uuid'] = (string) Str::uuid();

    // Ambil studio_uuid dari session
    $studio = session('studio');

    if (!$studio) {
        return redirect()->route('owner.profile_trainer')->with('error', 'Studio tidak ditemukan.');
    }

    $validatedData['studio_uuid'] = $studio->studio_uuid;

    // Upload foto trainer
    if ($request->hasFile('trainer_foto')) {
        $file = $request->file('trainer_foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/trainer_foto'), $filename);
        $validatedData['trainer_foto'] = $filename;
    }

    Trainer::create($validatedData);

    return redirect()->route('owner.profile_trainer')->with('success', 'Trainer berhasil ditambahkan.');
}

    public function edit($trainer_uuid)
    {
        $trainer = Trainer::findOrFail($trainer_uuid);

        return view('owner.dashboard.edit_trainer', [
            'title' => 'Edit Trainer',
            'trainer' => $trainer,
        ]);
    }

    public function update(Request $request, $trainer_uuid)
    {
        $validatedData = $request->validate([
            'trainer_name' => ['required', 'string', 'max:255'],
            'trainer_desk' => ['nullable', 'string', 'max:500'],
            'trainer_umur' => ['required', 'integer'],
            'trainer_sertif' => ['nullable', 'string'],
            'trainer_link_fb' => ['nullable', 'url'],
            'trainer_link_ig' => ['nullable', 'url'],
            'trainer_link_tw' => ['nullable', 'url'],
            'trainer_foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $trainer = Trainer::findOrFail($trainer_uuid);

        if ($request->hasFile('trainer_foto')) {
            if ($trainer->trainer_foto && file_exists(public_path('images/trainer_foto/' . $trainer->trainer_foto))) {
                unlink(public_path('images/trainer_foto/' . $trainer->trainer_foto));
            }
            $file = $request->file('trainer_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/trainer_foto'), $filename);
            $validatedData['trainer_foto'] = $filename;
        }

        $trainer->update($validatedData);

        return redirect()->route('owner.profile_trainer')->with('success', 'Trainer berhasil diperbarui.');
    }

    public function destroy($trainer_uuid)
    {
        $trainer = Trainer::findOrFail($trainer_uuid);

        // Hapus file foto jika ada
        if ($trainer->trainer_foto && file_exists(public_path('images/trainer_foto/' . $trainer->trainer_foto))) {
            unlink(public_path('images/trainer_foto/' . $trainer->trainer_foto));
        }

        $trainer->delete();

        return redirect()->route('owner.profile_trainer')->with('success', 'Trainer berhasil dihapus.');
    }
}