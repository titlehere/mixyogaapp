<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\KelasYoga;
use App\Models\Trainer;
use App\Models\Pemesanan;
use App\Models\Review;
use Illuminate\Support\Str;

class JadwalController extends Controller
{
    public function index($kelas_uuid)
    {
        $kelas = KelasYoga::findOrFail($kelas_uuid);
        $jadwals = $kelas->jadwals()
            ->with('trainer')
            ->orderBy('jadwal_tgl', 'desc') // Urutkan dari tanggal terbaru
            ->get();

        return view('owner.dashboard.jadwal', [
            'title' => 'Jadwal Kelas',
            'kelas' => $kelas,
            'jadwals' => $jadwals,
        ]);
    }

    public function create($kelas_uuid)
    {
        $kelas = KelasYoga::findOrFail($kelas_uuid);
        $trainers = Trainer::where('studio_uuid', $kelas->studio_uuid)->get();

        return view('owner.dashboard.tambah_jadwal_kelas', [
            'kelas' => $kelas,
            'trainers' => $trainers,
        ]);
    }

    public function store(Request $request, $kelas_uuid)
    {
        $request->validate([
            'trainer_uuid' => 'required|exists:trainer,trainer_uuid',
            'jadwal_tgl' => 'required|date',
            'jadwal_wkt' => 'required|string',
            'jadwal_status' => 'required|string|in:Belum Mulai,Berlangsung,Selesai,Batal', // Validasi status
        ]);

        Jadwal::create([
            'jadwal_uuid' => (string) Str::uuid(),
            'kelas_uuid' => $kelas_uuid,
            'trainer_uuid' => $request->trainer_uuid,
            'jadwal_tgl' => $request->jadwal_tgl,
            'jadwal_wkt' => $request->jadwal_wkt,
            'jadwal_status' => $request->jadwal_status, // Simpan status
        ]);

        return redirect()->route('kelas.jadwal', $kelas_uuid)
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($kelas_uuid, $jadwal_uuid)
    {
        $jadwal = Jadwal::findOrFail($jadwal_uuid);
        $kelas = KelasYoga::findOrFail($kelas_uuid);
        $trainers = Trainer::where('studio_uuid', $kelas->studio_uuid)->get();

        return view('owner.dashboard.edit_jadwal_kelas', [
            'jadwal' => $jadwal,
            'kelas' => $kelas,
            'trainers' => $trainers,
        ]);
    }

    public function update(Request $request, $kelas_uuid, $jadwal_uuid)
    {
        $request->validate([
            'trainer_uuid' => 'required|exists:trainer,trainer_uuid',
            'jadwal_tgl' => 'required|date',
            'jadwal_wkt' => 'required|string',
            'jadwal_status' => 'required|string|in:Belum Mulai,Berlangsung,Selesai,Batal', // Validasi status
        ]);

        $jadwal = Jadwal::findOrFail($jadwal_uuid);
        $jadwal->update([
            'trainer_uuid' => $request->trainer_uuid,
            'jadwal_tgl' => $request->jadwal_tgl,
            'jadwal_wkt' => $request->jadwal_wkt,
            'jadwal_status' => $request->jadwal_status, // Simpan perubahan status
        ]);

        return redirect()->route('kelas.jadwal', $kelas_uuid)
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($kelas_uuid, $jadwal_uuid)
    {
        $jadwal = Jadwal::findOrFail($jadwal_uuid);
        $jadwal->delete();

        return redirect()->route('kelas.jadwal', $kelas_uuid)
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    public function showForMember($kelas_uuid)
    {
        $kelas = KelasYoga::findOrFail($kelas_uuid);
        $jadwals = $kelas->jadwals()
            ->with('trainer')
            ->orderBy('jadwal_tgl', 'desc') // Urutkan dari tanggal terbaru
            ->get();

        return view('member.kelas.jadwal_member', [
            'title' => 'Jadwal Kelas',
            'kelas' => $kelas,
            'jadwals' => $jadwals,
        ]);
    }    

    // Menampilkan daftar member yang memesan jadwal tertentu
    public function memberPesan($kelas_uuid, $jadwal_uuid)
    {
        $kelas = KelasYoga::findOrFail($kelas_uuid);
        $jadwal = Jadwal::where('jadwal_uuid', $jadwal_uuid)->with('kelas')->firstOrFail();
        $members = Pemesanan::where('jadwal_uuid', $jadwal_uuid)
        ->with('member') // Memastikan data member dimuat
        ->get();    

        $totalMembers = $members->count();

        return view('owner.dashboard.member_pesan', [
            'kelas' => $kelas,
            'jadwal' => $jadwal,
            'members' => $members,
            'totalMembers' => $totalMembers,
            'title' => 'Daftar Member yang Memesan Jadwal',
        ]);
    }

    // Menampilkan review member untuk jadwal tertentu
    public function memberReview($kelas_uuid, $jadwal_uuid)
    {
        $kelas = KelasYoga::findOrFail($kelas_uuid);
        $jadwal = Jadwal::where('jadwal_uuid', $jadwal_uuid)->with('kelas')->firstOrFail();
        $reviews = Review::where('jadwal_uuid', $jadwal_uuid)
            ->with('member')
            ->get();

        $totalRating = $reviews->sum('review_rating');
        $averageRating = $reviews->count() > 0 ? round($reviews->avg('review_rating'), 1) : 0;

        return view('owner.dashboard.member_review', [
            'kelas' => $kelas,
            'jadwal' => $jadwal,
            'reviews' => $reviews,
            'totalRating' => $totalRating,
            'averageRating' => $averageRating,
            'title' => 'Daftar Review dari Member',
        ]);
    }
}