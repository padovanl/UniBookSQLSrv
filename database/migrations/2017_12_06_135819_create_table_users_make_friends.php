<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersMakeFriends extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_make_friends', function (Blueprint $table) {
            //increments imposta automaticamente la chiave primaria, non serve usare il metodo primary()
	    $table->increments('id_request');
            $table->uuid('id_request_user');
            $table->uuid('id_user');
            $table->integer('status')->unsigned();

            //foreign key
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_request_user')->references('id_user')->on('users');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_make_friends');
    }
}
