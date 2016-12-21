<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id')->unsigned();  
            $table->integer('type_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('title', 200)->nullable(); 
            $table->text('caption')->nullable();
            $table->string('author', 200)->nullable();
            $table->string('file_name', 200)->nullable();
            $table->string('file_checksum', 40)->index(); //sha1 filechecksum
            $table->string('mime_type', 50);    
            $table->timestamps();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assets');
    }
}
