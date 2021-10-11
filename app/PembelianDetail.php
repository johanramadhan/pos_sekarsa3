<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'id_pembelian_detail';

    protected $hidden = [
        
    ];
    
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
    public function persediaan()
    {
        return $this->hasOne(Persediaan::class, 'id_persediaan', 'id_produk');
    }
}
