<?php

use Faker\Generator as Faker;


//da mettere a posto, mancano vari check

$factory->define(App\Users_make_friends::class, function (Faker $faker) {

      $userIDs = DB::table('users')->pluck('id_user')->all();

      $a = $faker->randomElement($userIDs);
      $b = $faker->randomElement($userIDs);
      $bool = False;

      //check inserimento di due id_user diversi
      while ($bool == False)
        if ($a == $b){
          $b = $faker->randomElement($userIDs);
          $bool = False;
        }
        else {//se i due valori non sono uguali
          //prendo i record
          $id1 = DB::table('users_make_friends')->where([['id_user', '=', '$a'],['id_request_user', '=', '$b'],])->first();
          $id2 = DB::table('users_make_friends')->where([['id_user', '=', '$b'],['id_request_user', '=', '$a'],])->first();

          if ($id1 != null || $id2 != null){
            $bool = False;
          }
          else{
            $bool = True;
          }
        }

      return [
        'id_user' => $a,
        'id_request_user' => $b,
        'status' => 0
    ];
});
