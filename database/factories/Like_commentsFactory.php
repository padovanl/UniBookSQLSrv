<?php

use Faker\Generator as Faker;

$factory->define(App\LikeComment::class, function (Faker $faker) {

        $userIDs = DB::table('users')->pluck('id_user')->all();
        $commentIDs = DB::table('comments')->pluck('id_comment')->all();

        $a = $faker->randomElement($userIDs);
        $b = $faker->randomElement($commentIDs);
        $bool = False;

        while ($bool == False)
          //prendo il record

          if (DB::table('like_comments')->where([['id_user', '=', '$a'],['id_comment', '=', '$b'],])->exists()){
            $bool = False;
            #$a = $faker->randomElement($userIDs);
            $b = $faker->randomElement($commentIDs);
          }
          else{
            $bool = True;
          }

        return [
          'id_user' => $a,
          'id_comment' => $b,
          'like' => 1
      ];
});
