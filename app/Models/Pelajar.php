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
        return $this->belongsTo('App\Models\User', 'id_user', 'id_user');
    }

    public function review()
    {
        return $this->hasMany('App\Models\Review', 'id_pelajar', 'id_pelajar');
    }

    public function order()
    {
        return $this->hasMany('App\Models\Order', 'id_pelajar', 'id_pelajar');
    }
}
