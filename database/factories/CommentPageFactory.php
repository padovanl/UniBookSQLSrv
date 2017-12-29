<?php

use Faker\Generator as Faker;

$factory->define(App\CommentPage::class, function (Faker $faker) {

  $comments = App\CommentP::all();
  #$pageIDs = DB::table('pages')->pluck('id_page')->all();

    foreach ($comments as $comment){
      if(!ctype_alnum($comment->id_author)){
          $CP = App\CommentPage::create([
          'id_page' => $comment->id_author,
          'id_comment' => $comment->id_comment
        ]);
      }
    }

});
