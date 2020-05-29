<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type',128);
            $table->integer('tid')->length(10);
            $table->string('preside',128)->default('[]');
            $table->string('course_title',1000)->default('[]');
            $table->string('course_lecturer',128)->default('[]');
            $table->string('song_title',1000)->default('[]');
            $table->string('song_lecturer',128)->default('[]');
            $table->date('add_date');
            $table->integer('last_edit')->length(10);
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
        Schema::drop('activity');
    }
}
