<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_main_banner';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id';

    /**
     * atribut yang dapat diisi
     */
    protected $fillable = [
        'nama_banner', 'link', 'is_show'
    ];
}
