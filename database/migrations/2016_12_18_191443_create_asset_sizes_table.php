<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_id')->unsigned()->index();
            $table->string('asset_url');
            $table->string('cdn_url');
            $table->integer('height')->unsigned();
            $table->integer('width')->unsigned(); 
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('asset_sizes');
    }
}
