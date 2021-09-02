<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'id_transaction';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }
    
    public function member()
    {
        return $this->hasOne(Customer::class, 'id', 'id_member');
    }

}
