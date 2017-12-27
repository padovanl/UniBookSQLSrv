<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReportPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::create('report_posts', function (Blueprint $table) {
            $table->increments('id_report');
            $table->integer('id_post')->unsigned();
            $table->string('status');
            $table->string('description');
            $table->timestamps();

            //foreign key
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
        Schema::dropIfExists('report_posts');
    }
}
