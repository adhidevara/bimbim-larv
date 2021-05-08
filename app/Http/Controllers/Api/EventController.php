<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getEvent(Request $request)
    {
        $event = Event::select('*')
            ->from('tb_events')
            ->paginate(9);

        $evnts = [];
        foreach ($event as $evnt) {
            $evnts[] = [
                'id_event'          => $evnt->id_event,
                'id_bidang'         => $evnt->id_bidang,
                'title'             => $evnt->title,
                'deskripsi'         => $evnt->deskripsi,
                'slug'              => $evnt->slug,
                'nama_cp'           => $evnt->nama_cp,
                'telp_cp'           => $evnt->telp_cp,
                'foto'              => $evnt->foto,
                'video'             => $evnt->video,
                'lokasi'            => $evnt->lokasi,
                'regis_link'        => $evnt->regis_link,
                'sertif_link'       => $evnt->sertif_link,
                'event_link'        => $evnt->event_link,
                'start_tgl_event'   => $evnt->start_tgl_event,
                'end_tgl_event'     => $evnt->end_tgl_event,
                'price'             => $evnt->price,
                'event_type'        => $evnt->event_type,
                'isPaid'            => $evnt->isPaid,
                'is_verified'       => $evnt->is_verified,
                'created_at'        => $evnt->created_at,
                'updated_at'        => $evnt->updated_at
            ];
        }

        return response()->json([
            'message' => 'success',
            'meta' => [
                'current_page'  => $event->currentPage(),
                'last_page'     => $event->lastPage(),
                'path'          => $event->path(),
                'per_page'      => $event->perPage(),
                'total'         => $event->total(),
            ],
            'data' => $evnts
        ],200);
    }

    public function detailEvent($id)
    {
        $event = Event::select()
            ->with('bidang')
            ->where('slug', '=', $id)
            ->get();

        if ($event->isEmpty()){
            return response()->json([
                'message' => 'Not Found',
                'data' => $event
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data'   => $event
        ], 200);
    }
}
