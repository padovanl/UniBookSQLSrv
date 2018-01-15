<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            //increments imposta automaticamente la chiave primaria, non serve usare il metodo primary()
            $table->increments('id_notification');
            $table->timestamps();
            $table->string('content');
            $table->boolean('new')->default(true);
            $table->uuid('id_user');
            $table->string('link');
	    $table->uuid('id_sender');

            //foreign key
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_sender')->references('id_user')->on('users');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
