<?php

use Faker\Generator as Faker;


#crea post e associato utente


$factory->define(App\Post::class, function (Faker $faker) {
    return [
          'fixed' => 0,
          'content' => $faker->paragraph,
          'id_author' => function () {
              return factory(App\User::class)->create()->id_user;
          }
      ];
});
