<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('tid')->length(10)->unsigned();
            $table->enum('type',['one','recls','three']);
            $table->integer('Dianchuanshi')->length(10);
            $table->integer('Dianchuanshi2')->length(10);
            $table->integer('Introducer')->length(10);
            $table->integer('Guarantor')->length(10);
            $table->string('preside',128)->default('[]');
            $table->integer('upper')->length(10);
            $table->integer('lowwer')->length(10);
            $table->string('action',128)->default('[]');
            $table->string('support',128)->default('[]');
            $table->string('counseling',128)->default('[]');
            $table->string('write',128)->default('[]');
            $table->string('towel',128)->default('[]');
            $table->string('music',128)->default('[]');
            $table->string('service1',128)->default('[]');
            $table->string('traffic',128)->default('[]');
            $table->string('affairs',128)->default('[]');
            $table->string('cooker',128)->default('[]');
            $table->integer('uplow')->length(10)->unsigned();
            $table->string('sambo',128)->default('[]');
            $table->integer('add')->length(10)->unsigned();
            $table->integer('aegis')->length(10)->unsigned();
            $table->string('flower',128)->default('[]');
            $table->string('accounting',128)->default('[]');
            $table->string('course_title',512)->default('[]');
            $table->string('course_lecturer',128)->default('[]');
            $table->string('song_title',512)->default('[]');
            $table->string('song_lecturer')->default('[]');
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
        Schema::drop('agenda');
    }
}
