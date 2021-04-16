<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\Mitra;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

class MitraController extends Controller
{
    public function getGuru(Request $request)
    {
        $mitra = Mitra::select('*')
            ->from('tb_mitras')
            ->where('id_bidang', '=', 1)
            ->paginate(9);

        $mtrs = [];
        foreach ($mitra as $mtr) {
            $mtrs[] = [
                'id_mitra' => $mtr->id_mitra,
                'id_bidang' => $mtr->id_bidang,
                'id_user' => $mtr->id_user,
                'nama' => $mtr->nama,
                'kota' => $mtr->kota,
                'title' => $mtr->title,
                'foto' => $mtr->foto,
                'slug' => $mtr->slug,
                'is_verified' => $mtr->is_verified,
            ];
        }

        return response()->json([
            'message' => 'success',
            'meta' => [
                'current_page'  => $mitra->currentPage(),
                'last_page'     => $mitra->lastPage(),
                'path'          => $mitra->path(),
                'per_page'      => $mitra->perPage(),
                'total'         => $mitra->total(),
            ],
            'data' => $mtrs
        ],200);
    }

    public function detailGuru($id)
    {
        $mitra = Mitra::select()
            ->with('user')
            ->with('bidang')
            ->with('review')
            ->with('mapelUnggulan')
            ->where('id_bidang', '=', 1)
            ->where('slug', '=', $id)
            ->get();

        $cntData = count($mitra[0]->review);

        if ($mitra->isEmpty()){
            return response()->json([
                'message' => 'Not Found',
                'data' => $mitra
            ], 404);
        }

        if ($mitra[0]->review->isEmpty() || $cntData == 0){
            return response()->json([
                'message' => 'success',
                'meta' => [
                    'rate' => 0,
                    'jmlUlasan' => 0,
                ],
                'data' => $mitra
            ], 200);
        }
        else{
            $sumData = 0;
            foreach ($mitra[0]->review as $rv){
                $sumData += $rv->rate;
            }
            $cntData = count($mitra[0]->review);
            $rate = $sumData/$cntData;
        }

        return response()->json([
           'message' => 'success',
           'meta'    => [
               'rate' => $rate,
               'jmlUlasan' => $cntData
           ],
           'data'   => $mitra
        ], 200);
    }

    public function regisMitra(Request $request)
    {
        $input = $request->post();

        $reYTID = '/(?im)\b(?:https?:\/\/)?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)\/(?:(?:\??v=?i?=?\/?)|watch\?vi?=|watch\?.*?&v=|embed\/|)([A-Z0-9_-]{11})\S*(?=\s|$)/';
        preg_match_all($reYTID, $input['video'], $matches, PREG_SET_ORDER, 0);
        $getID = $matches[0][1];

        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required|min:4',
            'no_telepon' => 'required|numeric|min:3',
            'bidang' => 'required',
            'deskripsi' => 'required',
            'institusi' => 'required',
            'ipk' => 'required|numeric',
            'jk' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'kodePos' => 'required',
            'prodi' => 'required',
            'status_studi' => 'required',
            'tanggal' => 'required|date',
            'title' => 'required',
            'video' => ['required', 'regex:/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/'],
            'password' => 'required|min:6|same:c_password',
            'c_password' => 'required|min:6|same:password',
        ]);

        if ($validation->fails()){
            return response()->json([
                'message' => 'field_error',
                'data' => $validation->errors()
            ], 401);
        }

//        $foto = $request->file('foto');
//        $sizeFt = $foto->getSize();
//        $extTypeFt = $foto->getClientOriginalExtension();
//        if ($sizeFt >= 2000000){
//            return response()->json([
//                'message' => 'error',
//                'data' => 'Size over limit min.2MB'
//            ], 401);
//        }
//        if (!$extTypeFt == 'jpg'  ||
//            !$extTypeFt == 'jpeg' ||
//            !$extTypeFt == 'png'  ||
//            !$extTypeFt == 'JPG'  ||
//            !$extTypeFt == 'JPEG' ||
//            !$extTypeFt == 'PNG'
//        ){
//            return response()->json([
//                'message' => 'error',
//                'data' => 'Format Salah, harus JPG, JPEG, PNG',
//            ], 401);
//        }
//        $filenameWithExtFt = $foto->getClientOriginalName();
//        $filenameFt = pathinfo($filenameWithExtFt, PATHINFO_FILENAME);
//        $filenameSimpanFt = $filenameFt.'_'.time().'.'.$extTypeFt;
//        $pathFoto = $foto->storeAs('public/mitra_image', $filenameSimpanFt);
//
//
//        $cv = $request->file('cv');
//        $sizecv = $cv->getSize();
//        $extTypecv = $cv->getClientOriginalExtension();
//        if ($sizecv >= 2000000){
//            return response()->json([
//                'message' => 'error',
//                'data' => 'Size over limit min.2MB'
//            ], 401);
//        }
//        if (!$extTypecv == 'pdf'){
//            return response()->json([
//                'message' => 'error',
//                'data' => 'Format Salah, harus PDF',
//            ], 401);
//        }
//        $filenameWithExtcv = $cv->getClientOriginalName();
//        $filenamecv = pathinfo($filenameWithExtcv, PATHINFO_FILENAME);
//        $filenameSimpancv = $filenamecv.'_'.time().'.'.$extTypecv;
//        $pathcv = $cv->storeAs('public/mitra_cv', $filenameSimpancv);

        return response()->json([
            $getID,
            $request->post()
        ], 200);
    }
}
