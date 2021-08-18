<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->increments('id_transaction_detail');
            $table->string('code')->nullable();

            $table->integer('transactions_id');
            $table->integer('products_id');
            $table->Biginteger('harga_jual')->nullable();
            $table->integer('jumlah');
            $table->tinyInteger('diskon')->default(0);
            $table->integer('subtotal');
            $table->string('shipping_status')->nullable();
            $table->string('resi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
