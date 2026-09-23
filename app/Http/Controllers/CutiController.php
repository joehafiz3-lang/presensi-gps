<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = DB::table('cuti')->orderBy('kode_cuti')->get();
        return view('cuti.index', compact('cuti')); // 👈 Mengirimkan $cuti ke view
    }

    public function store(Request $request)
    {
        $kode_cuti = $request->kode_cuti;
        $nama_cuti = $request->nama_cuti;
        $jml_hari  = $request->jml_hari;

        try {
            $data = [
                'kode_cuti' => $kode_cuti,
                'nama_cuti' => $nama_cuti,
                'jml_hari'  => $jml_hari
            ];

            $simpan = DB::table('cuti')->insert($data);
            if ($simpan) {
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $kode_cuti = $request->kode_cuti;
        $cuti = DB::table('cuti')->where('kode_cuti', $kode_cuti)->first();
        return view('cuti.edit', compact('cuti'));
    }

    public function update(Request $request, $kode_cuti)
    {
        $nama_cuti = $request->nama_cuti;
        $jml_hari  = $request->jml_hari;

        try {
            $data = [
                'nama_cuti' => $nama_cuti,
                'jml_hari'  => $jml_hari
            ];

            $update = DB::table('cuti')->where('kode_cuti', $kode_cuti)->update($data);
            if ($update !== false) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function delete($kode_cuti)
    {
        $hapus = DB::table('cuti')->where('kode_cuti', $kode_cuti)->delete();
        if ($hapus) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}
