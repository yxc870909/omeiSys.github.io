<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('aid')->length(10);
            $table->integer('upid')->length(10);
            $table->string('name',16);
            $table->integer('Introducer')->length(10);
            $table->integer('Guarantor')->length(10);
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
            $table->enum('app',['yes','no'])->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agenda_user');
    }
}
