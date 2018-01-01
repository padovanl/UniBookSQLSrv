<?php

use Faker\Generator as Faker;

$factory->define(App\Users_follow_pages::class, function (Faker $faker) {

      $userIDs = DB::table('users')->pluck('id_user')->all();
      $pageIDs = DB::table('pages')->pluck('id_page')->all();

      $a = $faker->randomElement($userIDs);
      $b = $faker->randomElement($pageIDs);
      $bool = False;

      while ($bool == False)
        //prendo il record

        if (DB::table('users_follow_pages')->where([['id_user', '=', '$a'],['id_page', '=', '$b'],])->exists()){
          $bool = False;
          $a = $faker->randomElement($userIDs);
          #$b = $faker->randomElement($commentIDs);
        }
        else{
          $bool = True;
        }

      return [
        'id_user' => $a,
        'id_page' => $b,
    ];
});
