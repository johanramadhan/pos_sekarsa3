<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    protected $primaryKey = 'id_persediaan';
    protected $fillable = [
    'id_persediaan', 'categories_id', 'code', 'name_persediaan', 'stok', 'satuan', 'berat', 'total_berat', 'satuan_berat', 'merk', 'harga_beli', 'diskon', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }

    public function galleries()
    {
        // ->withTrashed()
        return $this->hasMany(PersediaanGallery::class, 'persediaans_id', 'id_persediaan');
    }
}
