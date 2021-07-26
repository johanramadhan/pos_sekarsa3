<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countdown extends Model
{
    protected $table = 'countdown';

    protected $fillable = [
        'name', 'date'
    ];

    protected $hidden = [
        
    ];
}
