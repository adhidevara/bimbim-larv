<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelajar;
use App\Models\Mitra;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

class MitraController extends Controller
{
    public function getMitra()
    {
        $mitra = Mitra::all();

        return response()->json([
            'message' => 'success',
            $mitra
        ],200);
    }
}
