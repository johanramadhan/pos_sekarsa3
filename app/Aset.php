<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use SoftDeletes;

    protected $table = 'asets';

    protected $fillable = [
        'code', 'pengeluaran_id', 'uraian', 'slug', 'jumlah', 'harga_beli', 'subtotal'
    ];

    protected $hidden = [
        
    ];
}
