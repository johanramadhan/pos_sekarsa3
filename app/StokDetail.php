<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokDetail extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'id_stok_detail';

    protected $hidden = [
        
    ];
    
    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'id_persediaan');
    }
    public function persediaan()
    {
        return $this->hasOne(Persediaan::class, 'id_persediaan', 'id_persediaan');
    }
}
