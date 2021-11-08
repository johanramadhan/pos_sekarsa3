<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $primaryKey = 'id_transaction_detail';
    protected $fillable = [
        'code', 'transactions_id', 'products_id', 'harga_jual', 'jumlah', 'diskon', 'subtotal', 'shipping_status', 'resi'
    ];

    public function produk()
    {
        return $this->hasOne(Produk::class, 'id_produk', 'products_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id_transaction', 'transactions_id');
    }
}
