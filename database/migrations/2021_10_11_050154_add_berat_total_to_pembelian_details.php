<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeratTotalToPembelianDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembelian_details', function (Blueprint $table) {
            $table->integer('harga_persatuan')->nullable()->after('harga_beli');
            $table->integer('berat_total')->nullable()->after('berat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembelian_details', function (Blueprint $table) {
            $table->dropColumn('harga_persatuan');
            $table->dropColumn('berat_total');
        });
    }
}
