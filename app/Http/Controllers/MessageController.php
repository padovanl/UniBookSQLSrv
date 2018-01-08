<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

use App\User;

class MessageController extends Controller
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

    public function index(){
    	if(!($this->controllaAutorizzazione()))
        	return redirect('login');

        $id = Cookie::get('session');
        $logged_user = User::where('id_user', '=', $id)->first();

    	return view('message', compact('logged_user'));
    }
}
