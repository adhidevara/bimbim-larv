<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_orders';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_order';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_order', 'id_pelajar', 'id_mitra', 'waktu_bimbingan', 'tarif', 'bukti_tf',
        'status_order', 'tgl_order', 'metode_tf'
    ];

    public function pelajar()
    {
        return $this->belongsTo('App\Models\Pelajar', 'id_pelajar', 'id_pelajar');
    }

    public function mitra()
    {
        return $this->belongsTo('App\Models\Mitra', 'id_mitra', 'id_mitra');
    }

    public function harga()
    {
        return $this->belongsTo('App\Models\Harga', 'id_harga', 'id_harga');
    }

    public function detailOrder()
    {
        return $this->hasMany('App\Models\DetailOrder', 'id_order', 'id_order');
    }
}
