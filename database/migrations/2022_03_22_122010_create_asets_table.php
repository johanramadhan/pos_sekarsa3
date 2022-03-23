<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->integer('pengeluaran_id')->nullable();
            $table->string('uraian')->nullable();
            $table->string('slug')->nullable();
            $table->string('satuan')->nullable();
            $table->integer('jumlah')->nullable();
            $table->bigInteger('harga_beli')->nullable();
            $table->bigInteger('subtotal')->nullable();
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
        Schema::dropIfExists('asets');
    }
}
