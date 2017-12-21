<?php

use Faker\Generator as Faker;

$factory->define(App\CommentPage::class, function (Faker $faker) {

  $commentIDs = DB::table('comments')->pluck('id_comment')->all();
  $pageIDs = DB::table('pages')->pluck('id_page')->all();

  return [
    'id_page' => $faker->randomElement($pageIDs),
    'id_comment' => $faker->randomElement($commentIDs)
    ];
});
