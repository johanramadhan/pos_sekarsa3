<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersediaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persediaans', function (Blueprint $table) {
            $table->increments('id_persediaan');
            $table->integer('categories_id');
            $table->string('code');
            $table->string('name_persediaan');
            $table->integer('stok')->nullable();
            $table->string('satuan');
            $table->integer('berat')->nullable();
            $table->bigInteger('total_berat')->nullable();
            $table->string('satuan_berat');
            $table->string('merk')->nullable();
            $table->integer('harga_beli');
            $table->tinyInteger('diskon')->default(0);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('persediaans');
    }
}
