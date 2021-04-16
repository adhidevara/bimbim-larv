<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelUnggulan extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_mapel_unggulan';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_mapel_unggulan';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_mitra', 'nama_mapel'
    ];

    /**
     * Relasi dengan user
     */
    public function mitra()
    {
        return $this->belongsTo('App\Models\Mitra', 'id_mitra', 'id_mitra');
    }
}
