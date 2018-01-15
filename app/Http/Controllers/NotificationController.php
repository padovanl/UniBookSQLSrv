<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;
use App\Notification;
use App\NotificationViewModel;

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
			$notificationList = Notification::where('id_user', '=', $logged_user->id_user)->latest()->get();
			$temp = collect();
			foreach ($notificationList as $n) {
				$user = User::where('id_user', '=', $n->id_sender)->first();
				$viewModel = new NotificationViewModel($n->id_notification, $n->content, '/' . $user->pic_path, $n->link, $n->new);
				$temp->push($viewModel);
			}
			$notificationList = $temp;
    		return view('notifications', compact('logged_user', 'notificationList'));
    	}
    }

    public function read(Request $request){
    	$id = $request->input('id');
    	Notification::where('id_notification', '=', $id)->update(['new' => false]);
    }
}
