<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_provinsi';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_provinsi', 'nama'
    ];

    /**
     * Relasi dengan Kota
     */
    public function kota()
    {
        return $this->hasMany('App\Models\Kota', 'id_provinsi', 'id_provinsi');
    }
}
