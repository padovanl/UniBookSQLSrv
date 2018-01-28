<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

use App\Users_make_friends;
use App\User;
use App\Notification;
use App\FriendRequestViewModel;
use Illuminate\Support\Facades\DB;

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

	//per le amicizie non uso queste funzioni, non le elimino perchè non so se valgono anche per le pagine
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
        }
				else{
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

  public function acceptFriend(Request $request){
    	$sender_user = User::where('id_user', '=', $request->input('id_user'))->first();
    	$logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
    	$id_request = $request->input('id_request');
    	$friendRequest = Users_make_friends::where('id_request', '=', $id_request)->first();
    	if(!$friendRequest)
    		return response()->json(['message' => 'Richiesta di amicizia non trovata.']);
			Users_make_friends::where('id_request', '=', $id_request)->update(['status' => 0]);
	    	//creo la notifica da inviare all'utente
            date_default_timezone_set('Europe/Rome');
	    	$notifica = new Notification();
	    	$notifica->new = true;
	    	$notifica->content = $logged_user->name . ' ' . $logged_user->surname . ' ha accettato la tua richiesta di amicizia';
	    	$notifica->id_user = $sender_user->id_user;
	    	$notifica->link = '/profile/user/' . $logged_user->id_user;
	        $notifica->id_sender = $logged_user->id_user;
	    	$notifica->save();

	    	return response()->json(['message' => 'Richiesta accettata.']);
    }

 	public function declineFriend(Request $request){
    	$sender_user = User::where('id_user', '=', $request->input('id_user'))->first();
    	$logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
    	$id_request = $request->input('id_request');
    	$friendRequest = Users_make_friends::where('id_request', '=', $id_request)->first();
    	if(!$friendRequest)
    		return response()->json(['message' => 'Richiesta di amicizia non trovata.']);
				Users_make_friends::where('id_request', '=', $id_request)->delete();
    	//creo la notifica da inviare all'utente
    	return response()->json(['message' => 'Richiesta rifiutata.']);
    }

  public function index(){
    	if(!$this->controllaAutorizzazione())
    		return view('/');
    	$logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
    	$requestList = Users_make_friends::where([['id_user', '=', $logged_user->id_user], ['status', '=', true]])->get();
    	$temp = collect();
    	foreach ($requestList as $r) {
    		$requestUser = User::where('id_user', '=', $r->id_request_user)->first();
    		$viewModel = new FriendRequestViewModel($r->id_request, $r->id_user, $r->id_request_user, $r->new, $requestUser->name . ' ' . $requestUser->surname . ' ti ha inviato una richiesta di amicizia.', $r->link, $requestUser);
    		$temp->push($viewModel);
    	}
    	$requestList = $temp;

    	return view('requestFriendList', compact('logged_user', 'requestList'));
    }

	public function AddFriend(Request $request){

			$data = request("data");
			$id = request("id");
			$logged_user = User::where('id_user', Cookie::get('session'))->first();
			if ($data == "1"){
				//inserisco il record che è comunque da confermare
				DB::table('users_make_friends')->insert(['id_user' => $id,'id_request_user' => $logged_user->id_user, 'status' => 1]);
				return response()->json(['value' => '1']);
			}
			else{
				DB::table('users_make_friends')->where([['id_request_user', '=', $logged_user->id_user], ['id_user', '=', $id]])->delete();
				return response()->json(['value' => '0']);
			}
		}
}
