<?php

use Faker\Generator as Faker;


#crea post e associato utente


$factory->define(App\PostP::class, function (Faker $faker) {

    $pageIDs = DB::table('pages')->pluck('id_page')->all();
    return [
          'fixed' => 0,
          'content' => $faker->paragraph,
          'id_author' => $faker->randomElement($pageIDs),
          'created_at' =>now(),
          'updated_at' =>now()
      ];
});
