<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelajar extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_pelajars';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_pelajar';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'id_user', 'nama', 'pendidikan', 'no_telepon', 'email', 'password',
        'alamat', 'foto', 'kota', 'provinsi', 'bio', 'is_verified'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Relasi dengan user
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

//    public function orders()
//    {
//        return $this->hasMany('App\Order', 'Id_Konsumen');
//    }
//
//    public function payment()
//    {
//        return $this->hasManyThrough('App\Payment', 'App\Order', 'Id_Konsumen', 'Id_Pembayaran');
//    }
}
