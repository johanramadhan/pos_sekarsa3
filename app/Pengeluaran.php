<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use SoftDeletes;

  protected $fillable = [
    'description', 'nominal'
  ];

  protected $hidden = [
    
  ];
}
