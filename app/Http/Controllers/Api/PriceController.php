<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Harga;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function getPrice(Request $request)
    {
        $harga = Harga::select('kota', $request->pendidikan.' as harga')
            ->from('tb_hargas')
            ->where('kota', '=', $request->kota)
            ->get();

        return response()->json([
            'message'   => 'success',
            'meta'      => ['pendidikan' => $request->pendidikan],
            'data'      => $harga
        ]);
    }
}
