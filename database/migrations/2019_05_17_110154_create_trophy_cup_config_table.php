<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrophyCupConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trophy_cup_config', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('asset_id')->nullable();
            $table->unsignedInteger('limit')->nullable();

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
        Schema::dropIfExists('trophy_cup_config');
    }
}
