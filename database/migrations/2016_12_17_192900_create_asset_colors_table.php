<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('asset_id')->unsigned()->index();
            $table->tinyInteger('red')->unsigned();
            $table->tinyInteger('green')->unsigned();
            $table->tinyInteger('blue')->unsigned();
            $table->smallInteger('hue')->unsigned();
            $table->tinyInteger('sat')->unsigned();
            $table->tinyInteger('lum')->unsigned();
            $table->integer('count')->unsigned();     
            $table->index(array('hue', 'sat', 'lum'), 'hsl_index'); 
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
        Schema::drop('asset_colors');
    }
}
