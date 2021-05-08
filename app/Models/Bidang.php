<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_bidangs';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_bidang';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_bidang',
        'kode_bidang',
        'nama_bidang',
    ];

    public function mitra()
    {
        return $this->hasMany('App\Models\Mitra', 'id_bidang', 'id_bidang');
    }

    public function event()
    {
        return $this->hasMany('App\Models\Event', 'id_bidang', 'id_bidang');
    }
}
