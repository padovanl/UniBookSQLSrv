<?php

use Faker\Generator as Faker;

#crea commenti fatti da pagine

$factory->define(App\ReportComment::class, function (Faker $faker) {
      $commentIDs = DB::table('comments')->pluck('id_comment')->all();
      $status = array(1 => 'aperta', 2 => 'esaminata');
      return [
            'description' => $faker->sentence(10),
            'id_comment' => $faker->randomElement($commentIDs),
            'status' => $faker->randomElement($status),

        ];
});
