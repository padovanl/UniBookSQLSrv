<?php

use Faker\Generator as Faker;

#crea commenti fatti da utenti

$factory->define(App\CommentU::class, function (Faker $faker) {
      $userIDs = DB::table('users')->pluck('id_user')->all();
      $postIDs = DB::table('posts')->pluck('id_post')->all();
      return [
            'content' => $faker->sentence(10),
            'id_author' => $faker->randomElement($userIDs),
            'id_post' => $faker->randomElement($postIDs),
            'created_at' =>$faker->date($format = 'Y-m-d', $max = 'now'),
            'updated_at' =>now()
        ];
});
