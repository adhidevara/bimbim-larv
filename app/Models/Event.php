<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_events';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_event';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_event',
        'id_bidang',
        'title',
        'deskripsi',
        'slug',
        'nama_cp',
        'telp_cp',
        'foto',
        'video',
        'lokasi',
        'regis_link',
        'sertif_link',
        'event_link',
        'start_tgl_event',
        'end_tgl_event',
        'price',
        'event_type',
        'isPaid',
        'is_verified',
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi dengan tb_bidangs
     */
    public function bidang()
    {
        return $this->belongsTo('App\Models\Bidang', 'id_bidang', 'id_bidang');
    }
}
