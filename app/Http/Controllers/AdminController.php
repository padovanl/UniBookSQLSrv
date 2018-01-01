<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;


use App\ReportPost;
use App\ReportComment;
use App\User;
use App\Post;
use App\PostPage;
use App\PostUser;
use App\CommentU;
use App\CommentP;
use App\CommentPage;
use App\CommentUser;
use App\Page;

class AdminController extends Controller
{
  public function dashboard() {
    //$reportList = ReportPost::orderBy('created_at')->get();
    //ritorno le dieci piu' recenti
    $reportList = ReportPost::latest()->paginate(10);
    //recupero numero utenti totali
    $totUser = User::where('confirmed', '=', 1)->count();
    //recupero numero post totali
    $totPost = Post::count();
    //recupero numero commenti totali
    $totComment = CommentP::count();
    //recupero numero pagine totali
    $totPage = Page::count();
    return view('/admin', compact('reportList', 'totUser', 'totPost', 'totComment', 'totPage'));
  }
  public function getPostDetails(Request $request)
  {
    $id = $request->input('id_report');
    $report = ReportPost::where('id_report', '=', $id)->first();
    //errore!
    //$post = Post::find($id);
    $post = Post::where('id_post', '=', $report->id_post)->first();
    return response()->json($post);
  }

  public function ignoreReportPost(Request $request){
    $id = $request->input('id_report');
    $report = ReportPost::where('id_report', '=', $id)->update(['status' => 'esaminata']);
    return response()->json(['message' => 'Operazione completata!']);
  }


  public function deletePost(Request $request){
    try{
        //recupero la notifica e la mrendo esaminata
        $id_report = $request->input('id_report');
        $report = ReportPost::where('id_report', '=', $id_report)->first();//update(['status' => 'esaminata']);
        $id_post = $report->id_post;



        // CANCELLARE I RIFERIMENTI ALLA TABELLA DEI LIKE, SIA POST CHE COMMENTI!!!!!!!!!


       

        //elimino i commenti associati al post
         //$comments = CommentUser::where('id_post', '=', $id_post)->get();
        $commentsParent = CommentU::where('id_post', '=', $id_post)->get();

        foreach ($commentsParent as $comment) {
            CommentUser::where('id_comment', '=', $comment->id_comment)->delete();
        }
        //$comments = CommentPage::where('id_post', '=', $id_post)->get();
        foreach ($commentsParent as $comment) {
            CommentPage::where('id_comment', '=', $comment->id_comment)->delete();
        }
         

         //$comments = CommentU::where('id_post', '=', $id_post)->get();
         foreach($commentsParent as $comment) {
            ReportComment::where('id_comment', '=', $comment->id_comment)->delete();
         }
        foreach($commentsParent as $comment) {
            CommentU::where('id_comment', '=', $comment->id_comment)->delete();
            //CommentP::where('id_comment', '=', $comment->id_comment)->delete();
         }





        //elimino la notifica
        ReportPost::where('id_post', '=', intval($id_post))->delete();
        
        //o l'uno o l'altro
        //$post = PostUser::where('id_post', '=', $id_post)->first();
        //if(!$post){
        //    $post->delete();
        //}else{
        //    $post = PostPage::where('id_post', '=', $id_post)->first();
        //    $post->delete();
        //}

        PostUser::where('id_post', '=', $id_post)->delete();
        PostPage::where('id_post', '=', $id_post)->delete();


        ////
        Post::where('id_post', '=', $id_post)->delete();
        //Post::where('id_post', '=', $id_post)->delete();
        //$post->delete();

        return response()->json(['message' => 'Operazione completata!']);

    }catch(Exception $e){
        return response()->json(['message' => $e->getMessage()]);
    }
    
  }

    public function testfunction(Request $request){
        if ($request->isMethod('post')){    
            $titolo = $request->input('title');
            $descrizione = $request->input('description');
            return response()->json(['titolo' => $titolo, 'descrizione' => $descrizione]); 
        }

        return response()->json(['response' => 'This is get method', 'numero' => 5]);
    }



}
