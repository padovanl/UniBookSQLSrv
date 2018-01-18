<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            //increments imposta automaticamente la chiave primaria, non serve usare il metodo primary()
            $table->increments('id_comment');
            $table->timestamps();
            $table->string('content', 1000);
            $table->uuid('id_author');
            $table->integer('id_post')->unsigned();

            //foreign key
            //se fa riferimento solo agli utenti, allora le pagine non possono creare post e commenti
            //$table->foreign('id_author')->references('id_user')->on('users');
            $table->foreign('id_post')->references('id_post')->on('posts');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
