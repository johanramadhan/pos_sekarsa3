<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countdown extends Model
{
    protected $fillable = [
        'name', 'date', 'hour'
    ];

    protected $hidden = [
        
    ];
}
