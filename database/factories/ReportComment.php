<?php

use Faker\Generator as Faker;


$factory->define(App\ReportComment::class, function (Faker $faker) {
      $commentIDs = DB::table('comments')->pluck('id_comment')->all();
      $status = array(1 => 'aperta', 2 => 'esaminata');
      $description = array(1 => 'Incita all\'odio', 2 => 'È una notizia falsa', 3 => 'È una minaccia');
      return [
            'description' => $faker->randomElement($description),
            'id_comment' => $faker->randomElement($commentIDs),
            'status' => $faker->randomElement($status),

        ];
});
