<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan
     */
    protected $table = 'tb_hargas';

    /**
     * Deklarasi custom primary key
     */
    protected $primaryKey = 'id_harga';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_harga',
        'kota',
        'sd', 'smp', 'sma-10', 'sma-11', 'sma-12'
    ];
}
