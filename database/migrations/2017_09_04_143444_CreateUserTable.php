<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    protected $timestamps = false;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type',16)->default('Generals');
            $table->enum('status',['active','inactive'])->default('inactive');
            $table->string('activation_code',60);
            $table->string('uid',32)->unique()->nullable();
            $table->string('password',60);
            $table->string('first_name',16);
            $table->string('last_name',16);
            $table->string('email')->unique()->nullable();
            $table->enum('gender',['male','female'])->default('male');
            $table->string('mobile',12);
            $table->string('phone',12)->nullable();
            $table->integer('year')->length(3)->nullable();
            $table->string('addr',128);
            $table->string('area',20);
            $table->string('position',128)->default('[]');
            $table->string('work',20);
            $table->string('edu',20);
            $table->string('skill',20);
            $table->integer('Dianchuanshi')->length(10);
            $table->string('Dianchuanshi_out', 16);
            $table->integer('Introducer')->length(10);
            $table->integer('Guarantor')->length(10);
            $table->integer('father')->length(10);
            $table->integer('mother')->length(10);
            $table->integer('spouse')->length(10);
            $table->string('brosis', 32)->default('[]');
            $table->string('child', 32)->default('[]');
            $table->string('relative', 32)->default('[]');
            $table->integer('regist_id')->length(10);
            $table->date('register_date')->nullable();
            $table->string('remember_token', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }
}
