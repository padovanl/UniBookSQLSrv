<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

use App\Users_make_friends;
use App\User;

class FriendshipController extends Controller
{
	protected function controllaAutorizzazione(){
        if(Cookie::has('session')){
            $id = Cookie::get('session');
            $user = User::where('id_user', '=', $id)->first();
            if(!$user){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    public function sendRequestFriend(Request $request){
    	if(!$this->controllaAutorizzazione())
    		return response()->json(['message' => 'Loggati!']);
    	$id_destination_user = $request->input('id_destination_user');
        $logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
        $alreadyFriends = Users_make_friends::where([['id_request_user', '=', $logged_user], ['id_user', '=', $id_destination_user]])->orWhere([['id_request_user', '=', $id_destination_user], ['id_user', '=', $logged_user]])->get();
        if(!$alreadyFriends){
        	$friendship = new Users_make_friends();
        	$friendship->id_request_user = $logged_user->id_user;
        	$friendship->id_user = $id_destination_user;
        	$friendship->status = 1;
        	$friendship->save();
        	return response()->json(['message' => 'Richiesta inviata!']);
        }else{
        	return response()->json(['message' => 'Siete gia\' amici!']);
        }
    }

    public function removeFriend(Request $request){
    	if(!$this->controllaAutorizzazione())
    		return response()->json(['message' => 'Loggati!']);
    	$id_destination_user = $request->input('id_destination_user');
    	$logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
    	$alreadyFriends = Users_make_friends::where([['id_request_user', '=', $logged_user], ['id_user', '=', $id_destination_user]])->orWhere([['id_request_user', '=', $id_destination_user], ['id_user', '=', $logged_user]])->delete();
    	return response()->json(['message' => 'Hai rimosso ' + $id_destination_user->name . $id_destination_user->surname . + '.']);
    }

    public function index(){
    	if(!$this->controllaAutorizzazione())
    		return view('/');
    	$logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
    	return view('requestFriendList', compact('logged_user'));
    }
}
