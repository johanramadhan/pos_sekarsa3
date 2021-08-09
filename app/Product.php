<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'name', 'slug', 'code', 'satuan', 'link', 'categories_id', 'stok', 'price_modal', 'price_jual', 'description'
    ];

    protected $hidden = [
        
    ];

    // merelasikan produk dengan gallery
    public function galleries()
    {
        // ->withTrashed()
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    // merelasikan produk dengan user
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    // merelasikan produk dengan category
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }
}
