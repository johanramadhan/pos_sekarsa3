<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeratPersatuanToPersediaans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persediaans', function (Blueprint $table) {
            $table->integer('harga_persatuan')->nullable()->after('harga_beli');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persediaans', function (Blueprint $table) {
            $table->dropColumn('harga_persatuan');
        });
    }
}
