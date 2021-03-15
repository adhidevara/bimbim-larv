<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validation->fails()){
            return response()->json([
                'message' => 'field_error',
                'data' => $validation->errors()
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->session()->regenerate();

        $token = $user->createToken('pelajar-'.$request->session()->regenerate(), ['akun:pelajar']);
        return response()->json([
            'message' => 'success',
            'data'    => [
                'user'  => $user,
                'token_login' => $token
            ]
        ], 200);
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required|min:4',
            'no_telepon' => 'required|numeric|min:3',
            'password' => 'required|min:6|same:c_password',
            'c_password' => 'required|min:6|same:password',
        ]);

        if ($validation->fails()){
            return response()->json([
                'message' => 'field_error',
                'data' => $validation->errors()
            ], 401);
        }

        $generated_token = hash('sha256', Str::random(40).$request->email);
        $verification_token = $generated_token;

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $pelajar = new Pelajar();
        $pelajar->nama = $input['nama'];
        $pelajar->no_telepon = $input['no_telepon'];
        $pelajar->email = $input['email'];
        $pelajar->password = $input['password'];
        $pelajar->id_user = $user->id;
        $pelajar->save();

        return response()->json([
            'message' => 'success',
            'data' => [
                'nama' => $input['nama'],
                'email' => $input['email'],
                'socialized_account' => false,
                'token_email' => $verification_token
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        \auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user = $request->user();
        $user->tokens()->where('tokenable_id', $user->id)->delete();

        return response()->json([
            'message' => 'success'
        ],200);
    }

    public function updateProfil(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'nama' => 'required|min:4',
            'kota' => 'required',
            'provinsi' => 'required',
            'alamat' => 'required',
            'pendidikan' => 'required',
            'no_telepon' => 'required|numeric|min:3',
        ]);

        $user = Auth::user();
        $input = $request->all();

        Pelajar::where('id_user', $user->id)
            ->update([
                'email' => $input['email'],
                'nama' => $input['nama'],
                'kota' => $input['kota'],
                'provinsi' => $input['provinsi'],
                'alamat' => $input['alamat'],
                'pendidikan' => $input['pendidikan'],
                'no_telepon' => $input['no_telepon'],
                'bio' => $input['bio'],
                'is_verified' => 1
        ]);

        if ($validation->fails()){
            return response()->json([
                'message' => 'field_error',
                'data' => $validation->errors()
            ], 401);
        }

        if (!$request->user()->tokenCan('akun:pelajar')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function detailUser()
    {
        $user = Auth::user();
        $pelajar = Pelajar::where('id_user', $user->id)
            ->get();
        return response()->json([
            'message' => 'success',
            'data' => $pelajar[0],
        ], 200);
    }

    public function test()
    {
        #test_code
    }











}
