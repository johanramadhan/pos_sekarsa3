<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalGallery extends Model
{
     protected $fillable = [
    'photos', 'proposals_id'
    ];

    protected $hidden = [
        
    ];

     // merelasikan produk gallery dengan produk
    public function proposal()
    {
        // ->withTrashed()
        return $this->belongsTo(Proposal::class, 'proposals_id', 'id');
    }
}
