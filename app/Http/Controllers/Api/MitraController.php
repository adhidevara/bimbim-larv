<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MapelUnggulan;
use App\Models\Mitra;
use Cassandra\Map;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
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
        //INPUT FROM USER
        $input = $request->post();

        //VALIDATION
        $input['bidang'] = ($input['bidang'] == 'BIM GURU') ? 1 : 2;

        error_reporting(0);
        if (!$input['video'] == null){
            $reYTID = '/(?im)\b(?:https?:\/\/)?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)\/(?:(?:\??v=?i?=?\/?)|watch\?vi?=|watch\?.*?&v=|embed\/|)([A-Z0-9_-]{11})\S*(?=\s|$)/';
            preg_match_all($reYTID, $input['video'], $matches, PREG_SET_ORDER, 0);
            $getID = $matches[0][1];
        }
        else{
            $getID = null;
        }

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
            'tarif' => 'numeric',
            'mapel_unggulan' => 'required',
            'tanggal' => 'required|date',
            'title' => 'required',
            //'video' => ['regex:/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-\_]*)(&(amp;)?‌​[\w\?‌​=]*)?/'],
            'password' => 'required|min:6|same:c_password',
            'c_password' => 'required|min:6|same:password',
        ]);

        if ($validation->fails()){
            return response()->json([
                'message' => 'field_error',
                'data' => $validation->errors()
            ], 401);
        }
        //END VALIDATION

        //UPLOAD IMAGE & CV
        $foto = $request->file('foto');
        $sizeFt = $foto->getSize();
        $extTypeFt = $foto->getClientOriginalExtension();
        if ($sizeFt >= 2000000){
            return response()->json([
                'message' => 'error',
                'data' => 'Size over limit min.2MB'
            ], 401);
        }
        if (!$extTypeFt == 'jpg'  ||
            !$extTypeFt == 'jpeg' ||
            !$extTypeFt == 'png'  ||
            !$extTypeFt == 'JPG'  ||
            !$extTypeFt == 'JPEG' ||
            !$extTypeFt == 'PNG'
        ){
            return response()->json([
                'message' => 'error',
                'data' => 'Format file salah, harus JPG, JPEG, PNG',
            ], 401);
        }
        $filenameWithExtFt = $foto->getClientOriginalName();
        $filenameFt = pathinfo($filenameWithExtFt, PATHINFO_FILENAME);
        $filenameSimpanFt = md5($filenameFt).'_'.time().'.'.$extTypeFt;
        $pathFoto = $foto->storeAs('public/mitra_image', $filenameSimpanFt);


        $cv = $request->file('cv');
        $sizecv = $cv->getSize();
        $extTypecv = $cv->getClientOriginalExtension();
        if ($sizecv >= 2000000){
            return response()->json([
                'message' => 'error',
                'data' => 'Size over limit min.2MB'
            ], 401);
        }
        if (!$extTypecv == 'pdf'){
            return response()->json([
                'message' => 'error',
                'data' => 'Format file salah, harus PDF',
            ], 401);
        }
        $filenameWithExtcv = $cv->getClientOriginalName();
        $filenamecv = pathinfo($filenameWithExtcv, PATHINFO_FILENAME);
        $filenameSimpancv = md5($filenamecv).'_'.time().'.'.$extTypecv;
        $pathcv = $cv->storeAs('public/mitra_cv', $filenameSimpancv);
        //END UPLOAD IMAGE & CV

        //STORE DATA TO DB
        $generated_token = hash('sha256', Str::random(40).$input['email']);
        $verification_token = $generated_token;

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $mitra = new Mitra();
        $mitra->id_user       = $user->id;
        $mitra->id_bidang     = $input['bidang'];
        $mitra->nama          = $input['nama'];
        $mitra->no_telepon    = $input['no_telepon'];
        $mitra->email         = $input['email'];
        $mitra->password      = $input['password'];
        $mitra->tgl_lahir     = $input['tanggal'];
        $mitra->jk            = $input['jk'];
        $mitra->kota          = $input['kota'];
        $mitra->kecamatan     = $input['kecamatan'];
        $mitra->kelurahan     = $input['kelurahan'];
        $mitra->provinsi      = $input['provinsi'];
        $mitra->alamat        = $input['alamat'];
        $mitra->kode_pos      = $input['kodePos'];
        $mitra->institusi     = $input['institusi'];
        $mitra->prodi         = $input['prodi'];
        $mitra->ipk           = $input['ipk'];
        $mitra->status_studi  = $input['status_studi'];
        $mitra->title         = $input['title'];
        $mitra->deskripsi     = $input['deskripsi'];
        $mitra->tarif         = $input['tarif'];
        $mitra->slug          = Str::slug($input['nama']." MT".$user->id."R ".$input['title'], '-');
        $mitra->foto          = env('BACKEND_URL').'/storage/mitra_image/'.$filenameSimpanFt;
        $mitra->video         = $input['video'];
        $mitra->cv            = env('BACKEND_URL').'/storage/mitra_cv/'.$filenameSimpancv;
        $mitra->is_verified   = 0;
        $mitra->save();

        $mapel = explode(",",$request->post('mapel_unggulan'));
        foreach ($mapel as $mpl){
            $mapel_unggulan = new MapelUnggulan();
            $mapel_unggulan->id_mitra = $mitra->id_mitra;
            $mapel_unggulan->nama_mapel = $mpl;
            $mapel_unggulan->save();
        }
        //END STORE DATA TO DB

        //RETURN DATA TO FRONTEND
        return response()->json([
            $getID,
            explode(",",$request->post('mapel_unggulan')),
            env('BACKEND_URL').'/storage/mitra_image/'.$filenameSimpanFt,
            env('BACKEND_URL').'/storage/mitra_cv/'.$filenameSimpancv,
        ], 200);
        //END RETURN DATA TO FRONTEND
    }
}
