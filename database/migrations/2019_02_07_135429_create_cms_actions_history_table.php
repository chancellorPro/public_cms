<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCmsActionsHistoryTable
 */
class CreateCmsActionsHistoryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_actions_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cms_user_id');
            $table->string('source', 100)->default('')->index();
            $table->string('action', 100)->default('')->index();
            $table->jsonb('data')->nullable();
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_actions_history');
    }
}
