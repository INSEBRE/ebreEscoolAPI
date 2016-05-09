<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table) {
            $table->increments('id');
            $table->string('givenName');
            $table->string('sn1');
            $table->string('sn2');
            $table->string('email')->unique();
            $table->string('official_id')->unique();
            $table->string('mobile');
            $table->timestamps();

            $table->integer('user_id')->unsigned();

        });

        Schema::table('person', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('person');
    }
}
