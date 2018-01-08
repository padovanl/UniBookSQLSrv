<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

use App\User;
use App\Message;

use App\ChatViewModel;


class MessageController extends Controller
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

    public function index(){
    	if(!($this->controllaAutorizzazione()))
        	return redirect('login');

        $id = Cookie::get('session');
        $logged_user = User::where('id_user', '=', $id)->first();

        //prendo tutti gli utenti
        $users = User::all();

        //$allMessages = Message::where('receiver', '=', $id)->orderBy('created_at', 'desc')->get();

        $messages = array();
        $cnt = 0;
        for($x = 0; $x < count($users); $x++){
            $tmp = Message::where([['receiver', '=', $id], ['sender', '=', $users[$x]->id_user]])->orWhere([['receiver', '=', $users[$x]->id_user], ['sender', '=', $id]])->orderBy('created_at', 'asc')->get();
            if(count($tmp) > 0){
                $viewModel = new ChatViewModel();
                $viewModel->from = $users[$x]->name . ' ' . $users[$x]->surname;
                $viewModel->to = $id;
                $viewModel->listMessage = $tmp;
                $viewModel->picPath = $users[$x]->pic_path;
                $viewModel->picPathReceiver = $logged_user->pic_path;
                $viewModel->fromId = $users[$x]->id_user;
                $messages[$cnt] = $viewModel;
                $cnt++;
            }
        }

    	return view('message', compact('logged_user', 'messages'));
    }

    public function changeChat(Request $request){
        return response()->json(['message' => 'Operazione completata!']);
    }
}
