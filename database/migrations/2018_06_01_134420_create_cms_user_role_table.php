<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCmsUserRoleTable
 */
class CreateCmsUserRoleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_user_role', function (Blueprint $table) {
            $table->unsignedInteger('cms_role_id');
            $table->unsignedInteger('cms_user_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->primary(['cms_role_id', 'cms_user_id']);
            $table->foreign('cms_user_id')->references('id')->on('cms_users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('cms_users')->onDelete('restrict');
            $table->foreign('cms_role_id')->references('id')->on('cms_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_user_role');
    }
}
