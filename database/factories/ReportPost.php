<?php

use Faker\Generator as Faker;


$factory->define(App\ReportPost::class, function (Faker $faker) {
      $postIDs = DB::table('posts')->pluck('id_post')->all();
      $status = array(1 => 'aperta', 2 => 'esaminata');
      return [
            'description' => $faker->sentence(10),
            'id_post' => $faker->randomElement($postIDs),
            'status' => $faker->randomElement($status),

        ];
});
