<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $comments = DB::table('comments')->get();
      #$pageIDs = DB::table('pages')->pluck('id_page')->all();

        foreach ($comments as $comment){
          if(preg_match("/[a-z]/i",$comment->id_author)){
              $CU = App\CommentUser::create([
              'id_user' => $comment->id_author,
              'id_comment' => $comment->id_comment
            ]);
          }
          else{
            $CP = App\CommentPage::create([
            'id_page' => $comment->id_author,
            'id_comment' => $comment->id_comment
          ]);
          }
        }
    }
}
