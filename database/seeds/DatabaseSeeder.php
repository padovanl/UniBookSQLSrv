<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users = factory(App\User::class, 5)->create();
      $posts = factory(App\Post::class, 10)->create();
      $commentsU = factory(App\CommentU::class, 15)->create();
      #$commentsP = factory(App\CommentP::class, 15)->create();
      $pages = factory(App\Page::class, 5)->create();
      #$page_comments = factory(App\CommentPage::class, 15)->create();
      $user_comments = factory(App\CommentUser::class, 15)->create();
    }
}
