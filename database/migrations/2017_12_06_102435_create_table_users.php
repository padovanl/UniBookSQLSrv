<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
           $table->uuid('id_user');
           $table->string('name');
           $table->string('surname');
           $table->date('birth_date');
           $table->string('email')->unique();
           //0 =  normale 1 = admin
           $table->integer('admin')->default(0);
           $table->boolean('confirmed')->default(false);
           $table->string('pwd_hash');
           $table->string('pic_path');
           $table->boolean('ban')->default(false);
           $table->timestamps();
           //true = male, false = female
	         $table->boolean('gender');
           $table->string('citta');
	   $table->boolean('profiloPubblico')->default(false);
           //primary key
           $table->primary('id_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
