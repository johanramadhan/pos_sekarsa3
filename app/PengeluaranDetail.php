<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengeluaranDetail extends Model
{
    protected $guarded = [];

    protected $primaryKey = 'id_pengeluaran_detail';

    public function pengeluaran()
    {
        return $this->hasOne(Pengeluaran::class, 'id_pengeluaran', 'id_pengeluaran');
    }
}
