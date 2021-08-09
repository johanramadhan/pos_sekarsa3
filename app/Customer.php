<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'name', 'slug', 'phone', 'gender', 'address', 'email', 'description'
    ];

    protected $hidden = [
        
    ];
}
