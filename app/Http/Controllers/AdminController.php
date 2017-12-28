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
}
