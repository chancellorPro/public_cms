<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('news_id');
            $table->unsignedInteger('asset_id')->nullable();
            $table->unsignedInteger('sender_id')->index();
            $table->unsignedInteger('receiver_id')->index();
            $table->unsignedInteger('cms_user_id')->index();
            $table->unsignedInteger('gc')->nullable();
            $table->text('news_message');

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
        Schema::dropIfExists('event_log');
    }
}
