<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;
use App\Notification;

class NotificationController extends Controller
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
    	if($this->verify_cookie()){
    		$id = Cookie::get('session');
			$logged_user = User::where('id_user', '=', $id)->first();
			$notifications = Notification::where('id_user', '=', $logged_user->id_user)->latest()->get();
    		return view('notifications', compact('logged_user', 'notifications'));
    	}
    }
}
