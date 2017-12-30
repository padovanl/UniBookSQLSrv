<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReportPost;
use App\User;
use App\Post;
use App\CommentP;
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
    $id = $request->input('id_post');
    //errore!
    //$post = Post::find($id);
    $post = Post::where('id_post', '=', $id)->first();
    return response()->json($post);
  }

  public function ignoreReportPost(Request $request){
    $id = $request->input('id_report');
    $report = ReportPost::where('id_report', '=', $id)->update(['status' => 'esaminata']);
    return response()->json(['message' => 'Operazione completata']);
  }

    public function testfunction(Request $request)
    {
        if ($request->isMethod('post')){    
            $titolo = $request->input('title');
            $descrizione = $request->input('description');
            return response()->json(['titolo' => $titolo, 'descrizione' => $descrizione]); 
    }

        return response()->json(['response' => 'This is get method', 'numero' => 5]);
    }



}
