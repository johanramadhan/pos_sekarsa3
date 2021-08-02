<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJustifikasiToProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
             $table->string('justifikasi')->nullable()->after('max_requirement');
             $table->integer('realisasi')->nullable()->after('link');
             $table->bigInteger('price_dpa')->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('justifikasi');
            $table->dropColumn('realisasi');
            $table->dropColumn('note_realisasi');
        });
    }
}
