<?php

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {

    $userIDs = DB::table('users')->pluck('id_user')->all();
    return [
      'pic_path' => $faker->randomElement(['/assets/images/facebook1.jpg','/assets/images/facebook2.jpg','/assets/images/facebook3.jpeg','/assets/images/facebook4.jpeg','/assets/images/facebook5.jpeg','/assets/images/facebook6.jpeg','/assets/images/facebook7.jpeg']),
      'name' => $faker->sentence(),
      'id_user' => $faker->randomElement($userIDs)
    ];
});
