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
      $comments = factory(App\Comment::class, 5)->create();
      $pages = factory(App\Page::class, 5)->create();
      $page_comments = factory(App\CommentPage::class, 5)->create();
    }
}
