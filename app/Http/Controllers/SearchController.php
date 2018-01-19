<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Page;
use App\Users_make_friends;
use App\PostUser;
use App\CommentUser;
use App\CommentU;
use App\LikePost;

use Cookie;

class SearchController extends Controller{

  public function verify_cookie(){
    if (Cookie::has('session')){
      $id = Cookie::get('session');
      $user = User::where('id_user', '=', $id)->first();
      if(!$user)
        return false;
      else
        return true;
    }
    else{
      return false;
    }
  }

  public function search($search_term){

    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      $userprofile = User::where('id_user', request('id'))->first();

      return view('search', compact('logged_user', 'userprofile', 'search_term'));
    }
    else
      return view('login');
  }

  public function searchPage(Request $request, $search_term) {

    if ($request->has("take") && $request->input("take") != "")
      $take = $request->input("take");
    else
      $take = 5;

    if ($request->has("skip") && $request->input("skip") != "")
      $skip = $request->input("skip");
    else
      $skip = 0;

    $pages = Page::where("name" , "like", "%" . $search_term . "%")->take($take)->skip($skip)->get();

    if (count($pages) > 0)
      return response()->json($pages);
    else
      return response()->json("No results");
  }

  public function searchUsers(Request $request, $search_term) {

    if ($request->has("take") && $request->input("take") != "")
      $take = $request->input("take");
    else
      $take = 5;

    if ($request->has("skip") && $request->input("skip") != "")
      $skip = $request->input("skip");
    else
      $skip = 0;

    $users = User::where("name" , "like", "%" . $search_term . "%")
                ->orWhere("surname" , "like", "%" . $search_term . "%")
                ->select("id_user", "name", "surname", "email", "pic_path", "gender", "citta", "birth_date")
                ->take($take)
                ->skip($skip)
                ->get();

    if (count($users) > 0)
      return response()->json($users);
    else
      return response()->json("No results");
  }


}
?>
