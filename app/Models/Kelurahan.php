<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_kelurahan';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_kelurahan', 'id_kecamatan', 'nama'
    ];

    /**
     * Relasi dengan Kecamatan
     */
    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan', 'id_kecamatan', 'id_kecamatan');
    }
}
