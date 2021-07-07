<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'name', 'users_id', 'categories_id', 'price', 'description', 'slug', 'kondisi', 'status', 'qty', 'total_price', 'satuan', 'brand', 'link', 'fungsi'
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