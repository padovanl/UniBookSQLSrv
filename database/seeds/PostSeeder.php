<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $posts = DB::table('posts')->get();

        foreach ($posts as $post){
          if(preg_match("/[a-z]/i",$post->id_author)){
              $PU = App\PostUser::create([
              'id_user' => $post->id_author,
              'id_post' => $post->id_post
            ]);
          }
          else{
            $PP = App\PostPage::create([
            'id_page' => $post->id_author,
            'id_post' => $post->id_post
          ]);
          }
        }
    }
}
