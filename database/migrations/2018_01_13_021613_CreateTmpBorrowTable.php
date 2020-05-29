<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmpBorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmp_borrow', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('bid')->length(10);
            $table->integer('upid')->length(10);
            $table->integer('count')->length(10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tmp_borrow');
    }
}
