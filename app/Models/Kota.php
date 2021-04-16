<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_kota';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_kota', 'id_provinsi', 'nama'
    ];

    /**
     * Relasi dengan Provinsi
     */
    public function provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi', 'id_provinsi', 'id_provinsi');
    }

    /**
     * Relasi dengan Kecamatan
     */
    public function kecamatan()
    {
        return $this->hasMany('App\Models\Kecamatan', 'id_kota', 'id_kota');
    }
}
