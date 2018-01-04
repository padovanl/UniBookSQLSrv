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
use App\LikePost;
use App\LikeComment;

//viewModel
use App\DetailsReportViewModel;
use App\DetailsReportCommentViewModel;

class AdminController extends Controller
{
  public function dashboard() {
    //ritorno le piu' recenti
    $report = ReportPost::latest()->get();
    $el_per_page = 5;
    $current_page_post = 1;
    $num_page_reportPost = intval(($report->count()/$el_per_page));
    if(($report->count() % $el_per_page) != 0){
     $num_page_reportPost++;
    }
    $reportList = $report->splice($current_page_post * $el_per_page - 5, 5);

    //segnalazioni commenti
    $reportComment = ReportComment::latest()->get();
    $el_per_page_comment = 5;
    $current_page_comment = 1;
    $num_page_reportComment = intval(($reportComment->count()/$el_per_page_comment));
    if(($reportComment->count() % $el_per_page_comment) != 0){
     $num_page_reportComment++;
    }
    $reportListComment = $reportComment->splice($current_page_comment * $el_per_page - 5, 5);

    //recupero numero utenti totali
    $totUser = User::where('confirmed', '=', 1)->count();
    //recupero numero post totali
    $totPost = Post::count();
    //recupero numero commenti totali
    $totComment = CommentP::count();
    //recupero numero pagine totali
    $totPage = Page::count();
    return view('/admin', compact('reportList', 'reportListComment','totUser', 'totPost', 'totComment', 'totPage', 'num_page_reportPost', 'num_page_reportComment'));
  }

  public function getPostDetails(Request $request){
    $id = $request->input('id_report');
    $report = ReportPost::where('id_report', '=', $id)->first();

    $post = Post::where('id_post', '=', $report->id_post)->first();


    $viewModel = new DetailsReportViewModel();
    $viewModel->content = $post->content;
    $viewModel->id_report = $report->id_report;

    $tmp = PostPage::where('id_post', '=', $post->id_post)->first();
    if(!$tmp){
        //devo cercare l'autore tra gli utenti
        $tmp = PostUser::where('id_post', '=', $post->id_post)->first();
        $author = User::where('id_user', '=', $tmp->id_user)->first();
        $viewModel->linkProfiloAutore = "/profile/" . $author->id_user;
        $viewModel->nomeAutore = $author->name . " " . $author->surname;
        $viewModel->tipoAutore = 1;
    }else{
        $author = Page::where('id_page', '=', $tmp->id_page)->first();
        $viewModel->linkProfiloAutore = "/page/" . $author->id_page;
        $viewModel->nomeAutore = $author->nome;
        $viewModel->tipoAutore = 2;
    }
    return response()->json($viewModel);


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

        $commentsParent = CommentU::where('id_post', '=', $id_post)->get();

        foreach ($commentsParent as $comment) {
            LikeComment::where('id_comment', '=', $comment->id_comment)->delete();
        }
        
        foreach ($commentsParent as $comment) {
            CommentUser::where('id_comment', '=', $comment->id_comment)->delete();
        }
        //$comments = CommentPage::where('id_post', '=', $id_post)->get();
        foreach ($commentsParent as $comment) {
            CommentPage::where('id_comment', '=', $comment->id_comment)->delete();
        }
         
        foreach($commentsParent as $comment) {
            ReportComment::where('id_comment', '=', $comment->id_comment)->delete();
         }
        foreach($commentsParent as $comment) {
            CommentU::where('id_comment', '=', $comment->id_comment)->delete();
            //CommentP::where('id_comment', '=', $comment->id_comment)->delete();
         }


        //elimino la notifica
        ReportPost::where('id_post', '=', intval($id_post))->delete();
        
        LikePost::where('id_post', '=', $id_post)->delete();

        $ban = $request->input('ban');
        if($ban == 1){
            //recupero l'utente o la pagina per bannarlo
            $postTmp = PostUser::where('id_post', '=', $id_post)->first();
            if(!$postTmp){
                $postTmp = PostPage::where('id_post', '=', $id_post)->first();
                $page = Page::where('id_page', '=', $postTmp->id_page)->update(['ban' => true]);
            }else{
                $user = User::where('id_user', '=', $postTmp->id_user)->update(['ban' => true]);
            }
        }

       

        PostUser::where('id_post', '=', $id_post)->delete();
        PostPage::where('id_post', '=', $id_post)->delete();




        Post::where('id_post', '=', $id_post)->delete();


        return response()->json(['message' => 'Operazione completata!']);

    }catch(Exception $e){
        return response()->json(['message' => $e->getMessage()]);
    }
    
  }


  public function listReportPost(Request $request){
    $page = $request->input('page');
    //$report = ReportPost::latest()->get();

    $filter = $request->input('filter');
    if(!$filter || $filter == "Tutte"){
        $report = ReportPost::latest()->get();
    }else{
        if($filter == "Aperte"){
            $report = ReportPost::where('status', '=', 'aperta')->latest()->get();
        }else{
            //esaminate
            $report = ReportPost::where('status', '=', 'esaminata')->latest()->get();
        }
    }

    
    $motivo = $request->input('motivo');
    if($motivo == "Incita all'odio"){
        $report = $report->filter(function ($value, $key) {
            return $value->description == 'Incita all\'odio';
        });
    }
    if($motivo == "È una notizia falsa"){
        $report = $report->filter(function ($value, $key) {
            return $value->description == 'È una notizia falsa';
        });
    }
    if($motivo == "È una minaccia"){
        $report = $report->filter(function ($value, $key) {
            return $value->description == 'È una minaccia';
        });
    }


    $id_report = intval($request->input('idReportPost'));
    if($id_report != -1){
        $c = collect();
        foreach ($report as $r) {
            if(strpos($r->id_report, (string)$id_report))
                $c->push($r);
        }
        $report = $c;  
    }

    


    $el_per_page = 5;
    $num_page_reportPost = intval(($report->count()/$el_per_page));
    if(($report->count() % $el_per_page) != 0){
     $num_page_reportPost++;
    }    $id_report = $request->input('id');
    


    $reportList = $report->splice($page * 5 - 5, 5);    


    $array = array();
    //$length = count($reportList);
    $x = 0;

    $el_per_page = 5;
    //$current_page_post = 1;

    
    foreach ($reportList as $report) {
        $post = Post::where('id_post', '=', $report->id_post)->first();
        $viewModel = new DetailsReportViewModel();
        $viewModel->content = $post->content;
        $viewModel->id_report = $report->id_report;

        $viewModel->description = $report->description;
        $viewModel->status = $report->status;

        $date = $report->created_at;

        $viewModel->created_at = $date->format('Y-m-d H:i:s');

        $tmp = PostPage::where('id_post', '=', $post->id_post)->first();
        if(!$tmp){
            //devo cercare l'autore tra gli utenti
            $tmp = PostUser::where('id_post', '=', $post->id_post)->first();
            $author = User::where('id_user', '=', $tmp->id_user)->first();
            $viewModel->linkProfiloAutore = "/profile/user/" . $author->id_user;
            $viewModel->nomeAutore = $author->name . " " . $author->surname;
            $viewModel->tipoAutore = 1;
        }else{
            $author = Page::where('id_page', '=', $tmp->id_page)->first();
            $viewModel->linkProfiloAutore = "/profile/page/" . $author->id_page;
            $viewModel->nomeAutore = $author->nome;
            $viewModel->tipoAutore = 2;
        }
        $viewModel->totPage = $num_page_reportPost;
        $array[$x] = $viewModel;
        $x++;
    }

    
    return response()->json($array);
  }

  public function getCommentDetails(Request $request){
    $id = $request->input('id_report');
    $report = ReportComment::where('id_report', '=', $id)->first();

    $comment = CommentU::where('id_comment', '=', $report->id_comment)->first();


    $viewModel = new DetailsReportCommentViewModel();
    $viewModel->content = $comment->content;
    $viewModel->id_report = $report->id_report;

    $tmp = CommentPage::where('id_comment', '=', $comment->id_comment)->first();
    if(!$tmp){
        //devo cercare l'autore tra gli utenti
        $tmp = CommentUser::where('id_comment', '=', $comment->id_comment)->first();
        $author = User::where('id_user', '=', $tmp->id_user)->first();
        $viewModel->linkProfiloAutore = "/profile/" . $author->id_user;
        $viewModel->nomeAutore = $author->name . " " . $author->surname;
        $viewModel->tipoAutore = 1;
    }else{
        $author = Page::where('id_page', '=', $tmp->id_page)->first();
        $viewModel->linkProfiloAutore = "/page/" . $author->id_page;
        $viewModel->nomeAutore = $author->nome;
        $viewModel->tipoAutore = 2;
    }
    return response()->json($viewModel);


  }

  public function listReportComment(Request $request){
    $page = $request->input('page');
    //$report = ReportPost::latest()->get();

    $filter = $request->input('filter');
    if(!$filter || $filter == "Tutte"){
        $report = ReportComment::latest()->get();
    }else{
        if($filter == "Aperte"){
            $report = ReportComment::where('status', '=', 'aperta')->latest()->get();
        }else{
            //esaminate
            $report = ReportComment::where('status', '=', 'esaminata')->latest()->get();
        }
    }

    
    $motivo = $request->input('motivo');
    if($motivo == "Incita all'odio"){
        $report = $report->filter(function ($value, $key) {
            return $value->description == 'Incita all\'odio';
        });
    }
    if($motivo == "È una notizia falsa"){
        $report = $report->filter(function ($value, $key) {
            return $value->description == 'È una notizia falsa';
        });
    }
    if($motivo == "È una minaccia"){
        $report = $report->filter(function ($value, $key) {
            return $value->description == 'È una minaccia';
        });
    }


    $id_report = intval($request->input('idReportPost'));
    if($id_report != -1){
        $c = collect();
        foreach ($report as $r) {
            if(strpos($r->id_report, (string)$id_report))
                $c->push($r);
        }
        $report = $c;  
    }

    


    $el_per_page = 5;
    $num_page_reportPost = intval(($report->count()/$el_per_page));
    if(($report->count() % $el_per_page) != 0){
     $num_page_reportPost++;
    }    $id_report = $request->input('id');
    


    $reportList = $report->splice($page * 5 - 5, 5);    


    $array = array();
    //$length = count($reportList);
    $x = 0;

    $el_per_page = 5;
    //$current_page_post = 1;

    
    foreach ($reportList as $report) {
        $comment = CommentU::where('id_comment', '=', $report->id_comment)->first();
        $viewModel = new DetailsReportCommentViewModel();
        $viewModel->content = $comment->content;
        $viewModel->id_report = $report->id_report;

        $viewModel->description = $report->description;
        $viewModel->status = $report->status;

        $date = $report->created_at;

        $viewModel->created_at = $date->format('Y-m-d H:i:s');

        $tmp = CommentPage::where('id_comment', '=', $comment->id_comment)->first();
        if(!$tmp){
            //devo cercare l'autore tra gli utenti
            $tmp = CommentUser::where('id_comment', '=', $comment->id_comment)->first();
            $author = User::where('id_user', '=', $tmp->id_user)->first();
            $viewModel->linkProfiloAutore = "/profile/" . $author->id_user;
            $viewModel->nomeAutore = $author->name . " " . $author->surname;
            $viewModel->tipoAutore = 1;
        }else{
            $author = Page::where('id_page', '=', $tmp->id_page)->first();
            $viewModel->linkProfiloAutore = "/page/" . $author->id_page;
            $viewModel->nomeAutore = $author->nome;
            $viewModel->tipoAutore = 2;
        }
        $viewModel->totPage = $num_page_reportPost;
        $array[$x] = $viewModel;
        $x++;
    }

    
    return response()->json($array);
  }



}
