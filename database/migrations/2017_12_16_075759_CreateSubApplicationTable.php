<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_application', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('set_id')->length(10);
            $table->integer('sbid')->length(10);
            $table->string('area', 32);
            $table->integer('count')->length(10);
            $table->integer('receiver')->length(10);
            $table->date('receive_date');
            $table->enum('status',['process', 'finish'])->default('process');
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
        Schema::drop('sub_application');
    }
}
