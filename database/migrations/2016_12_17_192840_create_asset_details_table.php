<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('asset_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_id')->unsigned()->index();
            $table->string('camera', 100)->nullable();; 
            $table->string('aperture', 50)->nullable();; 
            $table->integer('color_space')->unsigned();
            $table->string('exposure', 200)->nullable();; 
            $table->integer('iso')->unsigned();
            $table->integer('focal_length')->unsigned();
            $table->integer('height')->unsigned();
            $table->integer('width')->unsigned(); 
            $table->integer('resolution')->unsigned(); 
            $table->tinyInteger('orientation')->unsigned();
            $table->string('software', 200)->nullable();;
            $table->integer('file_size')->unsigned();
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
        Schema::drop('asset_details');
    }
}
