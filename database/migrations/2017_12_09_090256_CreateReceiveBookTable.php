<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiveBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receive_books', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('cat',20);
            $table->string('number', 20);
            $table->string('location',20);
            $table->string('title',128);
            $table->string('img',20);
            $table->string('author',20);
            $table->string('isbn',128);
            $table->string('lan',20);
            $table->string('pub_year',5);
            $table->string('version',10);
            $table->string('no',10);
            $table->integer('price')->length(10);
            $table->integer('tid')->length(10);
            $table->integer('count')->length(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('receive_books');
    }
}
