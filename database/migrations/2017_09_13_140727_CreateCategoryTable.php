<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function(Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->enum('type', ['user_type','skill','gender','edu','area','receive_type','temple_type','library_books_type','books_type','position','work','group','group_type','cls_type','dispatch','lan']);
            $table->string('value',32);
            $table->string('word',32);
            $table->smallInteger('order')->length(16)->uniqid();
            $table->string('attribute',128);

            //$table->foreign('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category');
    }
}
