<?php

use Faker\Generator as Faker;


$factory->define(App\Message::class, function (Faker $faker) {
      $userIDs = DB::table('users')->pluck('id_user')->all();
      $letto = array(1 => true, 2 => false);
      return [
            'content' => $faker->sentence(10),
            'sender' => $faker->randomElement($userIDs),
            'receiver' => $faker->randomElement($userIDs),
            'letto' => $faker->randomElement($letto),

        ];
});
