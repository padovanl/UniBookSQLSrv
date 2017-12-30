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
      $users = factory(App\User::class, 10)->create();

      #creo pagine ENTITA' = pages
      $pages = factory(App\Page::class, 3)->create();

      #creo post fatti da utenti e da pagine ENTITA' = posts
      $postsU = factory(App\PostU::class, 5)->create();
      $postsP = factory(App\PostP::class, 5)->create();

      #creo commenti fatti da utenti e da pagine ENTITA' = comments
      $commentsU = factory(App\CommentU::class, 5)->create();
      $commentsP = factory(App\CommentP::class, 5)->create();

      #creo relazioni tra commenti fatti da utenti e da pagine ENTITA' = comments_user "or" comments_page
      #$page_comments = factory(App\CommentPage::class)->create();
      #$user_comments = factory(App\CommentUser::class, 5)->create();


      #creo relazioni tra post fatti da utenti e da pagine ENTITA' = posts_user "or" posts_page
      #$page_posts = factory(App\PostPage::class, 5)->create();
      #$user_posts = factory(App\PostUser::class, 5)->create();


      #creo amicizie, DEVONO SEMPRE essere < della metà del num di utenti, se no crea problemi ovviamente!!!!
      $friends = factory(App\Users_make_friends::class,4)->create();


      $report_comments = factory(App\ReportComment::class, 10)->create();
      $report_posts = factory(App\ReportPost::class, 10)->create();
    }
}
