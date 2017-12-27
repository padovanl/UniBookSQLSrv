<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReportComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::create('report_comments', function (Blueprint $table) {
            $table->increments('id_report');
            $table->integer('id_comment')->unsigned();
            $table->string('status');
            $table->string('description');
            $table->timestamps();

            //foreign key
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
        Schema::dropIfExists('report_comments');
    }
}
