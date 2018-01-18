<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePageLikeComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_like_comments', function (Blueprint $table) {
            //increments imposta automaticamente la chiave primaria, non serve usare il metodo primary()
            $table->integer('id_comment')->unsigned();
            $table->integer('id_page')->unsigned();
            $table->boolean('like');

            //foreign key
            $table->foreign('id_page')->references('id_page')->on('pages');
            $table->foreign('id_comment')->references('id_comment')->on('comments');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_like_comments');
    }
}
