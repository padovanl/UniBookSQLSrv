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
      $users = factory(App\User::class, 6)->create();

      #creo pagine ENTITA' = pages
      $pages = factory(App\Page::class, 6)->create();

      #creo post fatti da utenti e da pagine ENTITA' = posts
      $postsU = factory(App\PostU::class, 20)->create();
      $postsP = factory(App\PostP::class, 20)->create();

      #creo commenti fatti da utenti e da pagine ENTITA' = comments
      $commentsU = factory(App\CommentU::class, 50)->create();
      $commentsP = factory(App\CommentP::class, 50)->create();
      #servono due classi CommentU e CommentP che malgrado siano uguali,
      #si riferiscono a due factory diverse


      #creo relazioni tra commenti fatti da utenti e da pagine ENTITA' = comments_user "or" comments_page
      #$page_comments = factory(App\CommentPage::class)->create();
      #$user_comments = factory(App\CommentUser::class, 5)->create();


      #creo relazioni tra post fatti da utenti e da pagine ENTITA' = posts_user "or" posts_page
      #$page_posts = factory(App\PostPage::class, 5)->create();
      #$user_posts = factory(App\PostUser::class, 5)->create();

      #ovviamente al MAX cui possono essere n!/k!(n-k)! amicizie dove n = utenti
      #e k = 2 visto che le aicizie si stringono tra due utenti
      #nel caso max tutti sono amici di tutti!!!
      $friends = factory(App\Users_make_friends::class,6)->create();

      #like a commenti e post
      $like_comment = factory(App\Like_comments::class,6)->create();
      $like_post = factory(App\Like_posts::class,6)->create();

      #pagine seguite da utenti
      $follow_page = factory(App\Users_follow_pages::class,4)->create();

      $report_comments = factory(App\ReportComment::class, 10)->create();
    }
}
