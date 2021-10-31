<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaskecilDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaskecil_details', function (Blueprint $table) {
            $table->increments('id_kaskecil_detail');
            $table->integer('id_kaskecil');
            $table->string('code');
            $table->string('uraian');
            $table->integer('jenis_uang');
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
        Schema::dropIfExists('kaskecil_details');
    }
}
