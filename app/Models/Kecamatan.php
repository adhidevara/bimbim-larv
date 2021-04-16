<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_kecamatan';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_kota', 'id_kecamatan', 'nama'
    ];

    /**
     * Relasi dengan Kota
     */
    public function kota()
    {
        return $this->belongsTo('App\Models\Kota', 'id_kota', 'id_kota');
    }

    /**
     * Relasi dengan Kelurahan
     */
    public function kelurahan()
    {
        return $this->hasMany('App\Models\Kelurahan', 'id_kecamatan', 'id_kecamatan');
    }
}
