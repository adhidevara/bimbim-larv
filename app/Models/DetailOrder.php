<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_detail_orders';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_detail_order';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_order', 'id_detail_order', 'keterangan', 'created_at', 'updated_at'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'id_order', 'id_order');
    }
}
