<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class DaerahController extends Controller
{
    public function getProvinsi()
    {
        $provinsi = Provinsi::with('kota')->get();
        return response()->json([
            'provinsi' => $provinsi
        ], 200);
    }

    public function getKota($id_provinsi)
    {
        $kota = Kota::with('provinsi')->with('kecamatan')->where('id_provinsi', '=', $id_provinsi)->get();
        return response()->json([
            'kota_kabupaten' => $kota
        ], 200);
    }

    public function getKecamatan($id_kota)
    {
        $kecamatan = Kecamatan::with('kota')->with('kelurahan')->where('id_kota', '=', $id_kota)->get();
        return response()->json([
            'kecamatan' => $kecamatan
        ], 200);
    }

    public function getKelurahan($id_kecamatan)
    {
        $kelurahan = Kelurahan::with('kecamatan')->where('id_kecamatan', '=', $id_kecamatan)->get();
        return response()->json([
            'kelurahan' => $kelurahan
        ], 200);
    }
}
