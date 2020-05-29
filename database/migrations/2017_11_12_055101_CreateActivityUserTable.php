<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('aid')->length(10)->unsigned();
            $table->integer('upid')->length(10);
            $table->string('name',16);
            $table->enum('gender',['male','female'])->default('male');
            $table->string('mobile',12);
            $table->string('phone',12)->nullable();
            $table->integer('year')->length(3)->nullable();
            $table->string('temple',128);
            $table->string('addr',128);
            $table->string('remark',128);
            $table->string('edu',20);
            $table->string('skill',20);
            $table->enum('inDB',['yes','no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activity_user');
    }
}
