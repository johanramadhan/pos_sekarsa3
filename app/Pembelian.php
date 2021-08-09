<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
    'id_pembelian', 'id_supplier', 'total_item', 'total_harga', 'diskon', 'bayar'
    ];
    protected $primaryKey = 'id_pembelian';

    protected $hidden = [
        
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_pembelian', 'id_supplier');
    }
}
