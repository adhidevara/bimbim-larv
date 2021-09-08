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
        'id_mitra', 'id_user', 'id_bidang',
        'nama', 'no_telepon', 'email', 'tgl_lahir', 'jk',
        'kota', 'kecamatan', 'kelurahan', 'provinsi', 'alamat', 'kode_pos',
        'institusi', 'prodi', 'ipk', 'status_studi',
        'title', 'deskripsi', 'tarif', 'slug',
        'foto', 'video', 'cv',
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

    public function review()
    {
        return $this->hasMany('App\Models\Review', 'id_mitra', 'id_mitra');
    }

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'id_mitra', 'id_mitra');
    }

    public function mapelUnggulan()
    {
        return $this->hasMany('App\Models\MapelUnggulan', 'id_mitra', 'id_mitra');
    }



}
