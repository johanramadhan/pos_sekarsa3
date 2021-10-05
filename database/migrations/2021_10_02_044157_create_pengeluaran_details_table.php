<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_details', function (Blueprint $table) {
            $table->increments('id_pengeluaran_detail');
            $table->string('code');
            $table->string('uraian');
            $table->integer('id_pengeluaran');
            $table->integer('harga_beli');
            $table->integer('jumlah');
            $table->string('satuan');
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
        Schema::dropIfExists('pengeluaran_details');
    }
}
