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
            $table->string('official_id');
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('address');
            $table->string('locality_name');
            $table->string('mobile');
            $table->string('photo');
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
        Schema::drop('person');
    }
}
