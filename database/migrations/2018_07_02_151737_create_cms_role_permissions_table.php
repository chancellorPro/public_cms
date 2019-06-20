<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCmsRolePermissionsTable
 */
class CreateCmsRolePermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_role_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cms_role_id');
            $table->string('permission', 255);
            $table->timestamps();
            
            $table->unique(['cms_role_id', 'permission']);
            $table->foreign('cms_role_id', 'cms_role_permissions_fk0')
                ->references('id')
                ->on('cms_roles')
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_role_permissions');
    }
}
