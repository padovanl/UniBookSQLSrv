<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

use App\User;
use App\Message;

use App\ChatViewModel;
use App\MessageViewModel;


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
        $messages = array();
        $cnt = 0;
        for($x = 0; $x < count($users); $x++){
            $tmp = Message::where([['receiver', '=', $id], ['sender', '=', $users[$x]->id_user]])->orWhere([['receiver', '=', $users[$x]->id_user], ['sender', '=', $id]])->orderBy('created_at', 'asc')->get();
            if(count($tmp) > 0){
                $viewModel = new ChatViewModel();
                $viewModel->from = $users[$x]->name . ' ' . $users[$x]->surname;
                $viewModel->to = $id;
                $viewModel->listMessage = $tmp;
                //guardo se ci sono nuovi messaggi
                $viewModel->numNuovi = 0;
                foreach ($tmp as $t){
                    if(($t->receiver == $logged_user->id_user) && !$t->letto)
                        $viewModel->numNuovi++;
                }
                $viewModel->picPath = $users[$x]->pic_path;
                $viewModel->picPathReceiver = $logged_user->pic_path;
                $viewModel->fromId = $users[$x]->id_user;
                $messages[$cnt] = $viewModel;
                $cnt++;
            }
        }
        if(count($messages) > 0)
            $idFirstUser = $messages[0]->fromId;
        else
            $idFirstUser = 0;

    	return view('message', compact('logged_user', 'messages', 'idFirstUser'));
    }

    public function changeChat(Request $request){
        $id = Cookie::get('session');
        $logged_user = User::where('id_user', '=', $id)->first();
        $id_sender = $request->input('from');
        $tmp = Message::where([['receiver', '=', $id], ['sender', '=', $id_sender]])->orWhere([['receiver', '=', $id_sender], ['sender', '=', $id]])->orderBy('created_at', 'asc')->get();
        Message::where([['receiver', '=', $id], ['sender', '=', $id_sender]])->update(['letto' => true]);
        $sender = User::where('id_user', '=', $id_sender)->first();
        $chat = array();
        foreach ($tmp as $t) {
            if($t->sender == $logged_user->id_user)
                array_push($chat, new MessageViewModel($sender->name . $sender->surname, $logged_user->name . $logged_user->surname, $logged_user->pic_path, $sender->pic_path, $sender->id_user, 1, $t->content, $t->created_at->format('H:i')));
            else
                array_push($chat, new MessageViewModel($sender->name . $sender->surname, $logged_user->name . $logged_user->surname, $logged_user->pic_path, $sender->pic_path, $sender->id_user, 0, $t->content, $t->created_at->format('H:i')));
        }
        return response()->json($chat);
    }

    public function newMessage(Request $request){

        date_default_timezone_set('Europe/Rome');
        $id = Cookie::get('session');
        $logged_user = User::where('id_user', '=', $id)->first();
        $id_receiver = $request->input('to');
        $content = $request->input('message');
        $message = new Message();
        $message->content = $content;
        $message->sender = $logged_user->id_user;
        $message->receiver = $id_receiver;
        $message->letto = false;
        $message->save();
        return response()->json(['message' => 'Operazione completata']);
    }


}
