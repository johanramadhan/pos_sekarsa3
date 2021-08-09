<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
     protected $fillable = [
    'id_pembelian', 'id_prodct', 'harga_beli', 'jumlah', 'subtotal'
    ];

    protected $primaryKey = 'id_pembelian_detail';

    protected $hidden = [
        
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id_produk', 'id');
    }
}
