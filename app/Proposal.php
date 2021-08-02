<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'code', 'users_id', 'categories_id', 'name', 'slug', 'brand', 'qty', 'max_requirement', 'justifikasi', 'satuan', 'price', 'total_price', 'price_dpa', 'benefit', 'description', 'proposal_status', 'note', 'link', 'realisasi'
    ];

    protected $hidden = [
        
    ];

    public function galleries()
    {
        // ->withTrashed()
        return $this->hasMany(ProposalGallery::class, 'proposals_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }
}
