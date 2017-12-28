<?php

use Faker\Generator as Faker;

$factory->define(App\PostUser::class, function (Faker $faker) {

  $postIDs = DB::table('posts')->pluck('id_post')->all();
  $userIDs = DB::table('users')->pluck('id_user')->all();

  return [
    'id_user' => $faker->randomElement($userIDs),
    'id_post' => $faker->randomElement($postIDs)
    ];

});
