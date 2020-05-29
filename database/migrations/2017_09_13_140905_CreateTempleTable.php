<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temple', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',10);
            $table->enum('type',['family','public']);
            $table->string('area',20);
            $table->string('addr',128);
            $table->string('phone',10);
            $table->string('upid', 32)->default('[]');
            $table->date('start_date');
            $table->string('start_date2',50);
            $table->enum('bookstore',['true','false']);
            $table->enum('training',['true','false']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('temple');
    }
}
