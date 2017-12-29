<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommentUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::create('comments_user', function (Blueprint $table) {
            //increments imposta automaticamente la chiave primaria, non serve usare il metodo primary()
            $table->integer('id_comment')->unsigned();
            $table->uuid('id_user');

            //foreign key
            #$table->foreign('id_user')->references('id_user')->on('users');
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
        Schema::dropIfExists('comments_user');
    }
}
