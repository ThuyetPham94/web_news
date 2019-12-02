<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameContextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_contect', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_vi');
            $table->string('name_en');
            $table->string('photo');
            $table->json('photo_options');
            $table->json('children_options')->nullable();
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
        Schema::dropIfExists('game_contect');
    }
}
