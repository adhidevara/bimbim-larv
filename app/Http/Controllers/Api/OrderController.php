<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailOrder;
use App\Models\Harga;
use App\Models\Order;
use App\Models\Pelajar;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{
    public function checkOrder(Request $request)
    {
        $input = $request->post();

        $validation = Validator::make($request->all(), [
            'id_mitra'          => 'required',
            'id_pelajar'        => 'required',
        ]);

        if ($validation->fails()){
            return response()->json([
                'message' => 'field_error',
                'data' => $validation->errors()
            ], 401);
        }

        $order = Order::select()
            ->where('id_pelajar', '=', $input['id_pelajar'])
            ->where('id_mitra', '=', $input['id_mitra'])
            ->where('status_order', '=', 'unverified')
            ->where('metode_tf', '=', null)
            ->get();

        if (count($order) == 0){
            return response()->json([
                'message' => 'success',
                'data'    => 'confirm order'
            ], 200);
        }
        else{
            return response()->json([
                'message' => 'success',
                'data'    => 'order available'
            ], 200);
        }

    }

    public function getOrder($id_pelajar)
    {
        $jmlOrder = Order::select()
            ->where('id_pelajar', '=', $id_pelajar)
            ->where('status_order', '=', 'unverified')
            ->get();

        $order = Order::select()
            ->with('pelajar')
            ->with('mitra')
            ->with('harga')
            ->with('detailOrder')
            ->where('id_pelajar', '=', $id_pelajar)
            ->orderBy('id_order', 'desc')
            ->paginate(9);

        return response()->json([
            'message' => 'success',
            'meta'    => [
                'jmlBimbingan'  => count($jmlOrder),
                'current_page'  => $order->currentPage(),
                'last_page'     => $order->lastPage(),
                'path'          => $order->path(),
                'per_page'      => $order->perPage(),
                'total'         => $order->total(),
            ],
            'data'    => $order
        ], 200);
    }

    public function createOrder(Request $request)
    {
        $input = $request->post();

        $validation = Validator::make($request->all(), [
            'id_mitra'          => 'required',
            'id_pelajar'        => 'required',
            'id_bidang'         => 'required',
            'kota'              => 'required',
            'waktu_bimbingan'   => 'required',
            'tgl_bimbingan'     => 'required',
            'metode_tf'         => 'required',
        ]);

        if ($validation->fails()){
            return response()->json([
                'message' => 'field_error',
                'data' => $validation->errors()
            ], 401);
        }

        $harga = Harga::select('id_harga', $input['pendidikan'].' as pendidikan')
            ->where('kota', '=', $input['kota'])
            ->get();

        $order = new Order();
        $order->id_pelajar      = $input['id_pelajar'];
        $order->id_mitra        = $input['id_mitra'];
        $order->id_bidang       = $input['id_bidang'];
        $order->id_harga        = $harga[0]->id_harga;
        $order->waktu_bimbingan = $input['tgl_bimbingan'].' '.$input['waktu_bimbingan'];
        if ($input['id_bidang'] == 1){
            $order->tarif = $harga[0]->pendidikan;
        }
        elseif ($input['id_bidang'] == 2){
            $order->tarif = $input['tarif'];
        }
        $order->metode_tf       = $input['metode_tf'];
        $order->save();

        $detailOrder = new DetailOrder();
        $detailOrder->id_order          = $order->id_order;
        $detailOrder->tipe_keterangan   = "+";
        $detailOrder->keterangan        = "Tahap Pembayaran";
        $detailOrder->save();

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function uploadBuktiTf(Request $request)
    {
        $input = $request->all();

        //UPLOAD FOTO BUKTI TF
        $foto = $request->file('bukti_tf');
        $sizeFt = $foto->getSize();
        $extTypeFt = $foto->getClientOriginalExtension();
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
        $pathFoto = $foto->storeAs('public/bukti_tf', $filenameSimpanFt);

        Order::where('id_order', $input['id_order'])
            ->update([
                'bukti_tf'     => env('BACKEND_URL').'/storage/bukti_tf/'.$filenameSimpanFt
            ]);
        $detailOrder = new DetailOrder();
        $detailOrder->id_order = $input['id_order'];
        $detailOrder->tipe_keterangan = '+';
        $detailOrder->keterangan = 'Tahap Verifikasi Pembayaran';
        $detailOrder->save();

        return response()->json([
            'message' => 'success',
            env('BACKEND_URL').'/storage/bukti_tf/'.$filenameSimpanFt
        ], 200);
    }
}
