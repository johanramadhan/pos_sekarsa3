<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_details', function (Blueprint $table) {
            $table->increments('id_stok_detail');
            $table->string('code');
            $table->integer('id_stok');
            $table->integer('id_produk');
            $table->integer('harga_beli');
            $table->integer('jumlah');
            $table->integer('berat');
            $table->integer('subtotal');
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
        Schema::dropIfExists('stok_details');
    }
}
