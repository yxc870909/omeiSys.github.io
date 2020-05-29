<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regist', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('tid')->length(10)->unsigned();
            $table->integer('upper')->length(10);
            $table->integer('lowwer')->length(10);
            $table->string('action',128)->default();
            $table->string('support',128)->default();
            $table->string('service1',128)->default();
            $table->string('service2',128)->default();
            $table->string('towel',128)->default();
            $table->string('traffic',128)->default();
            $table->string('cooker',128)->default();
            $table->string('sambo',128)->default();
            $table->string('Introduction',128)->default();
            $table->string('preside',128)->default();
            $table->integer('uplow')->length(10)->unsigned();
            $table->integer('add')->length(10)->unsigned();
            $table->integer('translation')->length(10)->unsigned();
            $table->integer('peper')->length(10)->unsigned();
            $table->integer('aegis')->length(10)->unsigned();
            $table->date('add_date');
            $table->string('add_date2',128);
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
        Schema::drop('regist');
    }
}
