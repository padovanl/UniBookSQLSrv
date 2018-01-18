<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            //increments imposta automaticamente la chiave primaria, non serve usare il metodo primary()
            $table->increments('id_post');
            $table->timestamps();
            $table->string('content', 1000);
            $table->boolean('fixed')->default(false);
            $table->uuid('id_author');

            //foreign key
            //se fa riferimento solo agli utenti, allora le pagine non possono creare post e commenti
            //$table->foreign('id_author')->references('id_user')->on('users');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
