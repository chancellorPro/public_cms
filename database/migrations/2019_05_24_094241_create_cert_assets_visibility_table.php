<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertAssetsVisibilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cert_assets_visibility', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('asset_id')->nullable();
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cert_assets_visibility');
    }
}
