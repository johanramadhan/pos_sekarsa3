<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
     protected $fillable = [
    'code', 'id_pembelian', 'id_produk', 'harga_beli', 'jumlah', 'subtotal'
    ];

    protected $primaryKey = 'id_pembelian_detail';

    protected $hidden = [
        
    ];
    
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
}
