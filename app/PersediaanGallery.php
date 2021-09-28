<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersediaanGallery extends Model
{
    protected $fillable = [
    'photos', 'persediaans_id'
    ];

    protected $hidden = [
        
    ];

     // merelasikan produk gallery dengan produk
    public function persediaan()
    {
        // ->withTrashed()
        return $this->belongsTo(Persediaan::class, 'persediaans_id', 'id_persediaan');
    }
}
