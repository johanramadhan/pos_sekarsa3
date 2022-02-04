<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('code2')->unique();
            $table->boolean('type');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('email')->unique()->nullable();
            $table->bigInteger('phone')->unique()->nullable();
            $table->boolean('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('members');
    }
}
