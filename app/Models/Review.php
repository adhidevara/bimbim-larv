<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_reviews';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_review';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_review', 'id_pelajar', 'id_mitra',
        'pesan',
        'rate',
    ];

    public function pelajar()
    {
        return $this->belongsTo('App\Models\Pelajar', 'id_pelajar', 'id_pelajar');
    }

    public function mitra()
    {
        return $this->belongsTo('App\Models\Mitra', 'id_mitra', 'id_mitra');
    }
}
