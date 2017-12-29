<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommentPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::create('comments_page', function (Blueprint $table) {
            //increments imposta automaticamente la chiave primaria, non serve usare il metodo primary()
            $table->integer('id_comment')->unsigned();
            $table->integer('id_page')->unsigned();

            //foreign key
            #$table->foreign('id_page')->references('id_page')->on('pages');
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
        Schema::dropIfExists('comments_page');
    }
}
