<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('givenName');
            $table->string('sn1');
            $table->string('sn2');
            $table->string('email')->unique();
            $table->string('secondary_email');
            $table->string('official_id')->unique();
            $table->date('date_of_birth');
            $table->string('homePostalAddress');
            $table->string('locality_name');
            $table->string('mobile');
            $table->string('photo');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->integer('locality_id')->unsigned();

        });

        Schema::table('people', function ($table) {
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('locality_id')->references('id')->on('locality');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('people');
    }
}
