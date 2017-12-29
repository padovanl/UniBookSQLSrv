<?php

use Faker\Generator as Faker;


//da mettere a posto, mancano vari check 

$factory->define(App\Users_make_friends::class, function (Faker $faker) {

      $userIDs = DB::table('users')->pluck('id_user')->all();

      return [
        'id_user' => $faker->randomElement($userIDs),
        'id_request_user' => $faker->randomElement($userIDs),
        'status' => 0
    ];
});
