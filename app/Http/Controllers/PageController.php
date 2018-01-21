<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;
use App\Page;

use App\Users_make_friends;
use App\Users_follow_pages;
use App\Notification;


use App\PostPage;
use App\PostViewModel;
use App\Post;
use App\CommentP;
use App\CommentViewModel;
use App\LikePost;
use App\LikeComment;
use App\PageListViewModel;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    protected function verify_cookie()
    {
        if (Cookie::has('session')) {
            $id = Cookie::get('session');
            $user = User::where('id_user', '=', $id)->first();
            if (!$user)
                return false;
            else
                return true;
        } else {
            return false;
        }
    }

    public function index()
    {
        if (!$this->verify_cookie())
            return response()->json(['message' => 'Loggati!']);
        $logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
        $userspages = Page::where('id_user', '=', $logged_user->id_user)->get();
        $temp = collect();
        foreach ($userspages as $u) {
            $viewModel = new PageListViewModel($u->name, $u->id_user, '/' . $u->pic_path, $u->id_page);
            $temp->push($viewModel);
        }
        $viewModel = $temp;
        return view('pageIndex', compact('logged_user', 'userspages'));
    }

    public function create(Request $request)
    {
        $logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
        try {
            $input = $request->all();
            $page = new Page();
            $page->name = $input['nomePagina'];
            $page->ban = false;
            $page->id_user = $logged_user->id_user;
            $page->pic_path = '/';
            $page->save();
            //$page->pic_path = 'assets/images/' . $page->id_page . '.jpg';
            $temp = Page::orderBy('id_page', 'DESC')->get();
            if (count($temp) > 0) {
                $pageId = $temp[0]->id_page;
            } else {
                $pageId = 1;
            }
            $file = Input::file('image');
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if(is_null ($file)) {
                $page_image = '/assets/img/profilo.png';
            }else{
                $page_image = '/assets/images/' . $pageId . $ext;
                $file->move('assets/images/', $pageId . $ext);
            }

            Page::where('id_page', '=', $pageId)->update(['pic_path' =>  $page_image]);
            //$page->save();
            return redirect('/page/mypage');
        } catch (\Exception $e) {
            return view('/error', compact('e'));
        }

    }

    public function inviteFriends(Request $request)
    {
        $id_page = $request->input('id_page');
        $page = Page::where('id_page', '=', $id_page)->first();
        $logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
        //$friendships = Users_make_friends::where('id_request_user', '=', $logged_user->id_user)->get();
        $cnt = 0;
        //questa funzione sarebbe già fatta: basta scrivere User::firends($id) e torna un array di utenti
        $friendships = User::friends($logged_user->id_user);
        date_default_timezone_set('Europe/Rome');
        foreach ($friendships as $f) {
            $alreadyFollowPage = Users_follow_pages::where([['id_user', '=', $f->id_user], ['id_page', '=', $id_page]])->first();
            if (!$alreadyFollowPage) {
                $notification = new Notification();
                $notification->content = $logged_user->name . ' ' . $logged_user->surname . ' ti ha invitato a mettere mi piace alla sua pagina "' . $page->name . '".';
                $notification->id_user = $f->id_user;
                $notification->id_sender = $logged_user->id_user;
                $notification->new = true;
                $notification->link = '/profile/page/' . $id_page;
                $notification->save();
                $cnt++;
            }
        }
        return response()->json(['totInviti' => $cnt]);
    }

    public function changeImage(Request $request)
    {
        try {
            $id_page = $request->input('id_page');
            $page = Page::where('id_page', '=', $id_page)->first();

            $file = Input::file('image');
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            //unlink('assets/images' . $page->id_page . '.jpg');
            $file->move('assets/images', $page->id_page . $ext);
            Page::where('id_page', '=', $page->id_page)->update(['pic_path' => '/assets/images/' . $page->id_page . $ext]);
            return redirect('/profile/page/' . $page->id_page);
        } catch (\Exception $e) {
            return view('/error', compact('e'));
        }

    }
}
