<?php

use Faker\Generator as Faker;

#crea commenti fatti da pagine

$factory->define(App\CommentP::class, function (Faker $faker) {
      $pageIDs = DB::table('pages')->pluck('id_page')->all();
      $postIDs = DB::table('posts')->pluck('id_post')->all();
      return [
            'content' => $faker->sentence(10),
            'id_author' => $faker->randomElement($pageIDs),
            'id_post' => $faker->randomElement($postIDs),
            'created_at' =>now(),
            'updated_at' =>now()
        ];
});
