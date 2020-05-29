<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow_books', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('bbid')->length(10);
            $table->integer('upid')->length(10);
            $table->integer('count')->length(10);
            $table->enum('status',['out', 'back'])->default('out');
            $table->date('borrow_date');
            $table->date('return_date');
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
        Schema::drop('borrow_books');
    }
}
