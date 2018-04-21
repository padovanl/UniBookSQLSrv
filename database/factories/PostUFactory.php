<?php

use Faker\Generator as Faker;


#crea post e associato utente


$factory->define(App\PostU::class, function (Faker $faker) {

    $userIDs = DB::table('users')->pluck('id_user')->all();
    return [
          'fixed' => 0,
          'content' => $faker->paragraph,
          'id_author' => $faker->randomElement($userIDs),
          'created_at' =>date("Y-m-d"),
          'updated_at' =>date("Y-m-d"),
      ];
});
