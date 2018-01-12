<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;
use App\Message;
use App\Notification;

class GeneralAppController extends Controller{

  public function countNewMessage(Request $request){
      $id = $request->input('id_user');
      $newMessages = Message::where([['receiver', '=', $id], ['letto', '=', false]])->count();
      return response()->json(['newMessages' => $newMessages]);
  }

  public function getNotifications(){

  }

}
?>
