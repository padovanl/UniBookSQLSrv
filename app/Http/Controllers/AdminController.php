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
    //recupero numero utenti totali
    $totUser = User::where('confirmed', '=', 1)->count();
    //recupero numero post totali
    $totPost = Post::count();
    //recupero numero commenti totali
    $totComment = CommentP::count();
    //recupero numero pagine totali
    $totPage = Page::count();
    return view('/admin', compact('reportList', 'totUser', 'totPost', 'totComment', 'totPage', 'num_page_reportPost'));
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

        PostUser::where('id_post', '=', $id_post)->delete();
        PostPage::where('id_post', '=', $id_post)->delete();


        Post::where('id_post', '=', $id_post)->delete();


        return response()->json(['message' => 'Operazione completata!']);

    }catch(Exception $e){
        return response()->json(['message' => $e->getMessage()]);
    }
    
  }

  public function listReportPost(Request $request){
    $status = $request->input('scelta');
    if(!$status || $status == "Tutte"){
        $reports = ReportPost::latest()->paginate(10);
    }else{
        $numReport = ReportPost::count();
        if($status == "Aperte"){
            $reports = ReportPost::where('status', '=', 'aperta')->latest()->paginate($numReport);
        }else{
            $reports = ReportPost::where('status', '=', 'esaminata')->latest()->paginate($numReport);
        }
    }
    
    if($request->ajax()){
        //return view('admin.report.load', ['reports' => $reports])->render();
        return response()->json($reports);
    }
    return view('admin.report.post', compact('reports'));
  }

  public function listReportPost2(Request $request){
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

    $el_per_page = 5;
    $num_page_reportPost = intval(($report->count()/$el_per_page));
    if(($report->count() % $el_per_page) != 0){
     $num_page_reportPost++;
    }

    
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

    public function testfunction(Request $request){
        if ($request->isMethod('post')){    
            $titolo = $request->input('title');
            $descrizione = $request->input('description');
            return response()->json(['titolo' => $titolo, 'descrizione' => $descrizione]); 
        }

        return response()->json(['response' => 'This is get method', 'numero' => 5]);
    }



}
