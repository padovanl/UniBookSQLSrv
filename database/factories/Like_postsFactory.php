<?php

use Faker\Generator as Faker;

$factory->define(App\LikePost::class, function (Faker $faker) {
  $userIDs = DB::table('users')->pluck('id_user')->all();
  $postIDs = DB::table('posts')->pluck('id_post')->all();

  $a = $faker->randomElement($userIDs);
  $b = $faker->randomElement($postIDs);
  $bool = False;

  while ($bool == False)
    //prendo il record

    if (DB::table('like_posts')->where([['id_user', '=', '$a'],['id_post', '=', '$b'],])->exists()){
      $bool = False;
      #$a = $faker->randomElement($userIDs);
      $b = $faker->randomElement($postIDs);
    }
    else{
      $bool = True;
    }

  return [
    'id_user' => $a,
    'id_post' => $b,
    'like' => 1
];
});
