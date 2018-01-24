<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Cookie;
use DateTime;


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
use App\Message;

//viewModel
use App\DetailsReportViewModel;
use App\DetailsReportCommentViewModel;
use App\DetailsUserAdminViewModel;
use App\AdminDonutChartViewModel;
use App\DetailsPageAdminViewModel;

class AdminController extends Controller
{

    protected function controllaAutorizzazione(){
        if(Cookie::has('session')){
            $id = Cookie::get('session');
            $user = User::where('id_user', '=', $id)->first();
            if(!$user){
                return false;
            }else{
                if($user->admin == 1){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

  public function dashboard() {

    //controllo autorizzazioni
    if(!($this->controllaAutorizzazione()))
        return redirect('login');

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

    //lista utenti
    $userList = User::latest()->get();
    $el_per_page_user = 5;
    $current_page_user = 1;
    $num_page_user = intval(($userList->count()/$el_per_page_user));
    if(($userList->count() % $el_per_page_comment) != 0){
     $num_page_user++;
    }
    $userList = $userList->splice($current_page_user * $el_per_page - 5, 5);


    //lista pagine
    $pageList = Page::latest()->get();
    $el_per_page_page = 5;
    $current_page_page = 1;
    $num_page_page = intval(($pageList->count()/$el_per_page_page));
    if(($pageList->count() % $el_per_page_page) != 0){
     $num_page_page++;
    }
    $pageList = $pageList->splice($current_page_page * $el_per_page - 5, 5);

    //recupero numero utenti totali
    $totUser = User::where('confirmed', '=', 1)->count();
    //recupero numero post totali
    $totPost = Post::count();
    //recupero numero commenti totali
    $totComment = CommentP::count();
    //recupero numero pagine totali
    $totPage = Page::count();

    //dati per i grafici
    //donut chart
    $users = User::all();
    $donutChart = array();
    $cnt = 0;
    foreach ($users as $u){
        $find = false;
        for($cnt = 0; $cnt < count($donutChart) && !$find; $cnt++) {
            if($donutChart[$cnt]->citta == $u->citta){
                $find = true;
            }
        }
        if(!$find){
            $tmp2 = new AdminDonutChartViewModel();
            $tmp2->citta = $u->citta;
            $tmp2->count = 1;
            array_push($donutChart, $tmp2);
        }else{
            for($cnt = 0; $cnt < count($donutChart); $cnt++){
                if($donutChart[$cnt]->citta == $u->citta){
                    $donutChart[$cnt]->count += 1;
                }
            }
        }
    }
    //donut chart eta
        //donut chart
    $donutChartEta = array();
    $cnt = 0;
    //qui citta' equivale alla fascia di eta'
    $tmp2 = new AdminDonutChartViewModel();
    $tmp2->citta = '0 - 12 anni';
    $tmp2->count = 0;
    array_push($donutChartEta, $tmp2);
    $tmp2 = new AdminDonutChartViewModel();
    $tmp2->citta = '13 - 18 anni';
    $tmp2->count = 0;
    array_push($donutChartEta, $tmp2);
    $tmp2 = new AdminDonutChartViewModel();
    $tmp2->citta = '19 - 30 anni';
    $tmp2->count = 0;
    array_push($donutChartEta, $tmp2);
    $tmp2 = new AdminDonutChartViewModel();
    $tmp2->citta = '31 - 50 anni';
    $tmp2->count = 0;
    array_push($donutChartEta, $tmp2);
    $tmp2 = new AdminDonutChartViewModel();
    $tmp2->citta = 'over 50';
    $tmp2->count = 0;
    array_push($donutChartEta, $tmp2);

    foreach ($users as $u){
        $bday = new DateTime($u->birth_date);
        $today = new DateTime(); 
        $diff = $today->diff($bday);

        if(($diff->y >= 0) && ($diff->y <= 12))
            $donutChartEta[0]->count++;
        else if(($diff->y >= 13) && ($diff->y <= 18))
            $donutChartEta[1]->count++;
        else if(($diff->y >= 19) && ($diff->y <= 30))
            $donutChartEta[2]->count++;
        else if(($diff->y >= 31) && ($diff->y <= 50))
            $donutChartEta[3]->count++;
        else //pver 50
            $donutChartEta[4]->count++;

    }

    return view('/admin', compact('reportList', 'reportListComment', 'userList','totUser', 'totPost', 'totComment', 'totPage', 'num_page_reportPost', 'num_page_reportComment', 'num_page_user', 'donutChart', 'pageList', 'num_page_page', 'donutChartEta'));
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
        $viewModel->linkProfiloAutore = "/profile/user/" . $author->id_user;
        $viewModel->nomeAutore = $author->name . " " . $author->surname;
        $viewModel->tipoAutore = 1;
    }else{
        $author = Page::where('id_page', '=', $tmp->id_page)->first();
        $viewModel->linkProfiloAutore = "/profile/page/" . $author->id_page;
        $viewModel->nomeAutore = $author->name;
        $viewModel->tipoAutore = 2;
    }
    $viewModel->id_post = $post->id_post;
    
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
            if(strpos($r->id_report, (string)$id_report) || ($r->id_report == $id_report))
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

        $viewModel->created_at = $date->format('M j, Y H:i');

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
            $viewModel->nomeAutore = $author->name;
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

    
    if(is_numeric($comment->id_author)){
        $author = Page::where('id_page', '=', $comment->id_author)->first();
        $viewModel->linkProfiloAutore = "/profile/page/" . $author->id_page;
        $viewModel->nomeAutore = $author->name;
        $viewModel->tipoAutore = 2;
    }else{
        $author = User::where('id_user', '=', $comment->id_author)->first();
        $viewModel->linkProfiloAutore = "/profile/user/" . $author->id_user;
        $viewModel->nomeAutore = $author->name . " " . $author->surname;
        $viewModel->tipoAutore = 1;
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
            if(strpos($r->id_report, (string)$id_report) || ($r->id_report == $id_report))
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

        $viewModel->created_at = $date->format('M j, Y H:i');

        if(is_numeric($comment->id_author)){
            $author = Page::where('id_page', '=', $comment->id_author)->first();
            $viewModel->linkProfiloAutore = "/profile/page/" . $author->id_page;
            $viewModel->nomeAutore = $author->name;
            $viewModel->tipoAutore = 2;
        }else{
            $author = User::where('id_user', '=', $comment->id_author)->first();
            $viewModel->linkProfiloAutore = "/profile/user/" . $author->id_user;
            $viewModel->nomeAutore = $author->name . " " . $author->surname;
            $viewModel->tipoAutore = 1;
        }
        $viewModel->totPage = $num_page_reportPost;
        $array[$x] = $viewModel;
        $x++;
    }

    
    return response()->json($array);
  }

  public function ignoreReportComment(Request $request){
    $id = $request->input('id_report');
    $report = ReportComment::where('id_report', '=', $id)->update(['status' => 'esaminata']);
    return response()->json(['message' => 'Operazione completata!']);
  }


  public function deleteComment(Request $request){
    try{
        //recupero la notifica e la rendo esaminata
        $id_report = $request->input('id_report');
        $report = ReportComment::where('id_report', '=', $id_report)->first();//update(['status' => 'esaminata']);
        $id_comment = $report->id_comment;

        $comment = CommentU::where('id_comment', '=', $id_comment)->first();
        LikeComment::where('id_comment', '=', $comment->id_comment)->delete();
        
        

        //elimino la notifica
        ReportComment::where('id_comment', '=', intval($id_comment))->delete();
        

        $ban = $request->input('ban');
        if($ban == 1){
            //recupero l'utente o la pagina per bannarlo
            $postTmp = CommentUser::where('id_comment', '=', $id_comment)->first();
            if(!$postTmp){
                $postTmp = CommentPage::where('id_comment', '=', $id_comment)->first();
                $page = Page::where('id_page', '=', $postTmp->id_page)->update(['ban' => true]);
            }else{
                $user = User::where('id_user', '=', $postTmp->id_user)->update(['ban' => true]);
            }
        }

        CommentUser::where('id_comment', '=', $comment->id_comment)->delete();

        CommentPage::where('id_comment', '=', $comment->id_comment)->delete();

        $comment = CommentU::where('id_comment', '=', $id_comment)->delete();


        return response()->json(['message' => 'Operazione completata!']);

    }catch(Exception $e){
        return response()->json(['message' => $e->getMessage()]);
    }
    
  }



  public function listUser(Request $request){

    $page = $request->input('page');
    //$report = ReportPost::latest()->get();

    $filter = $request->input('filter');
    if(!$filter || $filter == "Tutti"){
        $users = User::latest()->get();
    }else{
        if($filter == "Bloccati"){
            $users = User::where('ban', '=', 1)->latest()->get();
        }else if($filter == 'Non attivi'){
            $users = User::where('confirmed', '=', false)->latest()->get();
        }else{
            $users = User::where('admin', '=', 1)->latest()->get();
        }
    }

    //IN REALTA' E' L'EMAIL
    $id_user = $request->input('idUser');

    if($id_user != -1){
        $c = collect();
        foreach ($users as $u) {

            //DA METTERE A POSTO!!!!!
            if(strpos($u->email, $id_user) !== false)
                $c->push($u);
        }
        $users = $c;  
    }


    $el_per_page = 5;
    $num_page_user = intval(($users->count()/$el_per_page));
    if(($users->count() % $el_per_page) != 0){
     $num_page_user++;
    }  
    


    $userList = $users->splice($page * 5 - 5, 5);    


    $array = array();
    //$length = count($reportList);
    $x = 0;

    //$current_page_post = 1;

    
    foreach ($userList as $u) {
        $viewModel = new DetailsUserAdminViewModel();
        $viewModel->id_user = $u->id_user;
        $viewModel->nome = $u->name . ' ' . $u->surname;
        $viewModel->ban = $u->ban;
        $viewModel->email = $u->email;
        $viewModel->created_at = $u->created_at->format('M j, Y H:i');
        $viewModel->admin = $u->admin;
        $viewModel->picPath = $u->pic_path;
        $viewModel->confirmEmail = $u->confirmed;
        $viewModel->totPage = $num_page_user;
        $array[$x] = $viewModel;
        $x++;
    }

    
    return response()->json($array); 
  }

  public function getUserDetails(Request $request){
    $id = $request->input('id_user');
    $u = User::where('id_user', '=', $id)->first();

     $viewModel = new DetailsUserAdminViewModel();
     $viewModel->id_user = $u->id_user;
     $viewModel->nome = $u->name . ' ' . $u->surname;
     $viewModel->ban = $u->ban;
     $viewModel->email = $u->email;
     $viewModel->created_at = $u->created_at->format('M j, Y H:i');
     $viewModel->admin = $u->admin;
     $viewModel->confirmEmail = $u->confirmed;
     $viewModel->picPath = '..' . $u->pic_path;
     $viewModel->totPage = 1;

    return response()->json($viewModel);


  }

  public function promuoviUser(Request $request){
    $id = $request->input('id_user');

    User::where([['id_user', '=', $id], ['admin', '=', false]])->update(['admin' => true]);

    return response()->json(['message' => 'Operazione completata!', 'body' => 'L\'utente è stato promosso a amministratore di UniBook.', 'classLabelAdd' => 'badge badge-primary', 'classLabelRemove' => '']);
  }

  public function retrocediUser(Request $request){
    $id = $request->input('id_user');

    User::where([['id_user', '=', $id], ['admin', '=', true]])->update(['admin' => false]);

    return response()->json(['message' => 'Operazione completata!', 'body' => 'L\'utente è stato retrocesso.', 'classLabelAdd' => '', 'classLabelRemove' => 'badge badge-primary']);
  }


  public function bloccaUser(Request $request){
    $id = $request->input('id_user');

    User::where([['id_user', '=', $id], ['ban', '=', false]])->update(['ban' => true]);

    return response()->json(['message' => 'Operazione completata!', 'body' => 'L\'utente è stato bloccato. Non potrà scrivere post e commentare su UniBook.', 'classLabelAdd' => 'badge badge-primary', 'classLabelRemove' => '']);
  }

  public function sbloccaUser(Request $request){
    $id = $request->input('id_user');

    User::where([['id_user', '=', $id], ['ban', '=', true]])->update(['ban' => false]);

    return response()->json(['message' => 'Operazione completata!', 'body' => 'L\'utente è stato sbloccato.', 'classLabelAdd' => 'badge badge-primary', 'classLabelRemove' => '']);
  }




  public function sendMessageUser(Request $request){
    if(Cookie::has('session')){
        $id_sender = Cookie::get('session');
        $id_receiver = $request->input('id_user');
        $text = $request->input('message');
        $newMessage = new Message();
        $newMessage->sender = $id_sender;
        $newMessage->receiver = $id_receiver;
        $newMessage->content = $text;
        $newMessage->letto = false;
        $newMessage->save();
        return response()->json(['message' => 'Operazione completata!', 'body' => 'Il messaggio è stato inviato con successo.']);
    }else{
        return response()->json(['message' => 'Errore!', 'body' => 'Non hai i permessi necessari.']);
    }
  }


  //////


  public function listPage(Request $request){

    $page = $request->input('page');
    //$report = ReportPost::latest()->get();

    $filter = $request->input('filter');
    if(!$filter || $filter == "Tutte"){
        $pages = Page::latest()->get();
    }else{
        $pages = Page::where('ban', '=', 1)->latest()->get();
    }


    $id_page = $request->input('idPage');
    if($id_page != -1){
        $c = collect();
        foreach ($pages as $p) {
            if(strpos(strtolower($p->name), strtolower($id_page)) !== false)
                $c->push($p);
        }
        $pages = $c;  
    }


    $el_per_page = 5;
    $num_page_page = intval(($pages->count()/$el_per_page));
    if(($pages->count() % $el_per_page) != 0){
     $num_page_page++;
    }  
    


    $pageList = $pages->splice($page * 5 - 5, 5);    


    $array = array();
    //$length = count($reportList);
    $x = 0;

    //$current_page_post = 1;

    
    foreach ($pageList as $p) {
        $viewModel = new DetailsPageAdminViewModel();
        $viewModel->id_page = $p->id_page;
        $viewModel->name = $p->name;
        $viewModel->ban = $p->ban;
        $viewModel->created_at = $p->created_at->format('M j, Y H:i');
        $viewModel->picPath = $p->pic_path;
        $viewModel->totPage = $num_page_page;
        $array[$x] = $viewModel;
        $x++;
    }

    
    return response()->json($array); 
  }

  public function getPageDetails(Request $request){
    $id = $request->input('id_page');
    $p = Page::where('id_page', '=', $id)->first();

    $viewModel = new DetailsPageAdminViewModel();
    $viewModel->id_page = $p->id_page;
    $viewModel->name = $p->name;
    $viewModel->ban = $p->ban;
    $admin = User::where('id_user', '=', $p->id_user)->first();
    $viewModel->linkAdmin = '/profile/user/' . $admin->id_user;
    $viewModel->nomeAdmin = $admin->name . ' ' . $admin->surname;
    $viewModel->created_at = $p->created_at->format('M j, Y H:i');
    $viewModel->picPath = '..' . $p->pic_path;
    $viewModel->totPage = 1;

    return response()->json($viewModel);


  }


public function bloccaPage(Request $request){
    $id = $request->input('id_page');

    Page::where([['id_page', '=', $id], ['ban', '=', false]])->update(['ban' => true]);

    return response()->json(['message' => 'Operazione completata!', 'body' => 'La pagina è stata bloccata. Non potrà scrivere post e commentare su UniBook.', 'classLabelAdd' => 'badge badge-primary', 'classLabelRemove' => '']);
  }

  public function sbloccaPage(Request $request){
    $id = $request->input('id_page');

    Page::where([['id_page', '=', $id], ['ban', '=', true]])->update(['ban' => false]);

    return response()->json(['message' => 'Operazione completata!', 'body' => 'La pagina è stata sbloccata.', 'classLabelAdd' => 'badge badge-primary', 'classLabelRemove' => '']);
  }




}
