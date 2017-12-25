<?php

use Faker\Generator as Faker;

$factory->define(App\CommentUser::class, function (Faker $faker) {

  $commentIDs = DB::table('comments')->pluck('id_comment')->all();
  $userIDs = DB::table('users')->pluck('id_user')->all();

  return [
    'id_user' => $faker->randomElement($userIDs),
    'id_comment' => $faker->randomElement($commentIDs)
    ];
});
