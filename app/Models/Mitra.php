<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_mitras';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_mitra';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_mitra', 'id_bidang',
        'nama',
        'no_telepon',
        'email',
        'kota', 'provinsi', 'alamat',
        'tgl_lahir',
        'jk',
        'institusi', 'prodi', 'ipk', 'status_studi',
        'deskripsi',
        'foto',
        'video',
        'cv',
        'is_verified'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Relasi dengan tb_bidangs
     */
    public function bidang()
    {
        return $this->belongsTo('App\Models\Bidang', 'id_bidang', 'id_bidang');
    }

    /**
     * Relasi dengan table users
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id');
    }
}
