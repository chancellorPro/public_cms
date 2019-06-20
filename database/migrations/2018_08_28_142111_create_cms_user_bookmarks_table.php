<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCmsUserBookmarksTable
 */
class CreateCmsUserBookmarksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_user_bookmarks', function (Blueprint $table) {
            $table->unsignedInteger('cms_user_id')->primary('cms_user_bookmarks_pk');
            $table->jsonb('bookmarks');
            
            $table->foreign('cms_user_id')->references('id')->on('cms_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_user_bookmarks');
    }
}
