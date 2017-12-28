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
    { #creo utenti ENTITA' = users
      $users = factory(App\User::class, 5)->create();

      #creo pagine ENTITA' = pages
      $pages = factory(App\Page::class, 5)->create();

      #creo post fatti da utenti e da pagine ENTITA' = posts
      $postsU = factory(App\PostU::class, 10)->create();
      $postsP = factory(App\PostP::class, 10)->create();

      #creo commenti fatti da utenti e da pagine ENTITA' = comments
      $commentsU = factory(App\CommentU::class, 15)->create();
      $commentsP = factory(App\CommentP::class, 15)->create();

      #creo relazioni tra commenti fatti da utenti e da pagine ENTITA' = comments_user "or" comments_page
      $page_comments = factory(App\CommentPage::class, 15)->create();
      $user_comments = factory(App\CommentUser::class, 15)->create();

      #creo relazioni tra post fatti da utenti e da pagine ENTITA' = posts_user "or" posts_page
      $page_posts = factory(App\PostPage::class, 15)->create();
      $user_posts = factory(App\PostUser::class, 15)->create();


      $report_comments = factory(App\ReportComment::class, 10)->create();
      $report_posts = factory(App\ReportPost::class, 10)->create();
    }
}
