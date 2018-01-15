<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;
use App\Message;
use App\Notification;
use App\Users_make_friends;

class GeneralAppController extends Controller{

  public function countNewMessage(Request $request){
      $id = $request->input('id_user');
      $newMessages = Message::where([['receiver', '=', $id], ['letto', '=', false]])->count();
      return response()->json(['newMessages' => $newMessages]);
  }

  public function getNotifications(Request $request){
    $id = $request->input('id_user');
    $newNot = Notification::where([['id_user', '=', $id], ['new', '=', true]])->count();
    return response()->json(['newNotifications' => $newNot]);
  }

  public function getFriendRequest(Request $request){
    $id = $request->input('id_user');
    $newReq = Users_make_friends::where([['id_user', '=', $id], ['status', '=', 1]])->count();
    return response()->json(['newRequest' => $newReq]);
  }

}
?>
