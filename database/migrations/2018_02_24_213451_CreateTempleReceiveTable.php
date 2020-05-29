<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempleReceiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temple_receive', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('spid')->length(10);
            $table->string('tid', 32);
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
        Schema::drop('temple_receive');
    }
}
