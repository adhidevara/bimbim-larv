<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function getAllBanner()
    {
        $banner = Banner::all()
            ->where('is_show', '=', 1);

        $bnrs = [];
        foreach ($banner as $bnr) {
            $bnrs[] = [
                'id'          => $bnr->id,
                'nama_banner' => $bnr->nama_banner,
                'link'        => $bnr->link,
                'href'        => $bnr->href,
            ];
        }

        return response()->json([
            'message' => 'success',
            'data' => $bnrs
        ],200);
    }
}
