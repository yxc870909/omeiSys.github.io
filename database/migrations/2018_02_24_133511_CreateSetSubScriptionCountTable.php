<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetSubScriptionCountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_subscription_count', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type', 32);
            $table->integer('year')->length(4);
            $table->string('area', 32);
            $table->integer('count')->length(10);
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
        Schema::drop('set_subscription_count');
    }
}
