<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaskecilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaskecils', function (Blueprint $table) {
            $table->increments('id_kaskecil');
            $table->string('code');
            $table->string('uraian')->nullable();
            $table->integer('debit')->nullable();
            $table->integer('kredit')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('kaskecils');
    }
}
