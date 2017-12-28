<?php

use Faker\Generator as Faker;

$factory->define(App\PostPage::class, function (Faker $faker) {

  $postIDs = DB::table('posts')->pluck('id_post')->all();
  $pageIDs = DB::table('pages')->pluck('id_page')->all();

  return [
    'id_page' => $faker->randomElement($pageIDs),
    'id_post' => $faker->randomElement($postIDs)
    ];

});
