<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecvApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recv_application', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('rbid')->length(10);
            $table->integer('upid')->length(10);
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
        Schema::drop('recv_application');
    }
}
