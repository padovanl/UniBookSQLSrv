<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;
use App\Page;

use App\PageListViewModel;

use Illuminate\Support\Facades\Input;


class PageController extends Controller
{
    protected function verify_cookie(){
		if (Cookie::has('session')){
			$id = Cookie::get('session');
			$user = User::where('id_user', '=', $id)->first();
			if(!$user)
				return false;
			else
				return true;
		}else{
			return false;
		}
	}

	public function index(){
		if(!$this->verify_cookie())
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

	public function create(Request $request){
		 $logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
		 $input = $request->all();
		 $page = new Page();
		 $page->name = $input['nomePagina'];
		 $page->ban = false;
		 $page->id_user = $logged_user->id_user;
		 $page->pic_path = '/';
		 $page->save();
         //$page->pic_path = 'assets/images/' . $page->id_page . '.jpg';
         $pageId = $page->id_page;
         $file = Input::file('image');
         $file->move('assets/images', $pageId . '.jpg');
         Page::where('id_page', '=', $pageId)->update(['pic_path' => 'assets/images/' . $page->id_page . '.jpg']);
         //$page->save();
         return redirect('/page/mypage');
	}
}
