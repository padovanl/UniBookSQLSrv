<?php

use Faker\Generator as Faker;


$factory->define(App\ReportPost::class, function (Faker $faker) {
      $postIDs = DB::table('posts')->pluck('id_post')->all();
      $status = array(1 => 'aperta', 2 => 'esaminata');
      $description = array(1 => 'Incita all\'odio', 2 => 'È una notizia falsa', 3 => 'È una minaccia');
      return [
            'description' => $faker->randomElement($description),
            'id_post' => $faker->randomElement($postIDs),
            'status' => $faker->randomElement($status),

        ];
});
