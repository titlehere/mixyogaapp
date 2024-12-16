<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Menampilkan daftar member
    public function tampilmember()
    {
        $x = new member();
        $hasil = $x->bacamember();
        return view('tampil_member', ['hasil' => $hasil]);
    }

    // Menampilkan form tambah member
    public function tambahmember()
    {
        return view('tambah_member');
    }

    // Menyimpan data member baru
    public function simpanmember(Request $request)
    {
        $x = new member();
        $x->simpanmember($request->all());
        return redirect('/axel'); // Redirect ke daftar member
    }

    // Menampilkan form edit member
    public function ubahmember($kode_member)
    {
        $x = new member();
        $hasil = $x->getmember($kode_member);
        return view('tampilubahmember', ['hasil' => $hasil]);
    }

    // Menyimpan perubahan data member
    public function simpanubahmember(Request $request)
    {
        $x = new member();

        if ($request->has('simpan')) {
            $kode_member = $request->kode_member;
            $data = $request->except(['simpan']);
            $x->ubahmember($kode_member, $data);
        }

        if ($request->has('hapus')) {
            $kode_member = $request->kode_member;
            $x->hapusmember($kode_member);
        }

        return redirect('/axel'); // Redirect ke daftar member
    }

    // Menghapus data member
    public function simpanhapusmember(Request $request)
    {
        $x = new member();
        $kode_member = $request->kode_member;
        $x->hapusmember($kode_member);
        return redirect('/axel');
    }
}