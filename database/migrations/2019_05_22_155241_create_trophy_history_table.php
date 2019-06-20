<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrophyHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trophy_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('news_id')->index();
            $table->unsignedInteger('sender_id')->index();
            $table->unsignedInteger('receiver_id')->index();
            $table->unsignedInteger('asset_id')->nullable();
            $table->unsignedInteger('cms_user')->index();

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
        Schema::dropIfExists('trophy_history');
    }
}
