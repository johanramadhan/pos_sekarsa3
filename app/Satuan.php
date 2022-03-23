<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{

    use SoftDeletes;
    protected $table = 'satuans';

  protected $fillable = [
    'name', 'slug'
  ];

  protected $hidden = [
    
  ];
}
