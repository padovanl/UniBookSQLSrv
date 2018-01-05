<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Users_make_friends;

class User extends Authenticatable
{
  protected $table = 'users';
  public $timestamps = true;


  public function scopeFriends($query, $id){
    $askedfriendsid = Users_make_friends::askedfriends($id)->get();
    $receivedfriendsid = Users_make_friends::requestfriends($id)->get();

    $userarray = array();
    foreach($askedfriendsid as $user){
        array_push($userarray, User::where('id_user', $user['id_user'])->first());
    }

    foreach($receivedfriendsid as $user){
        array_push($userarray, User::where('id_user', $user['id_request_user'])->first());
    }
    return $userarray;
  }

  public function scopePendingfriends($query, $id){
    $pendingaskedfriendsid = Users_make_friends::pendingasked($id)->get();
    $pendingrequestfriendsid = Users_make_friends::pendingrequests($id)->get();

    $requests = array();
    foreach($pendingaskedfriendsid as $user){
        array_push($requests, User::where('id_user', $user['id_user'])->first());
    }

    foreach($pendingrequestfriendsid as $user){
        array_push($requests, User::where('id_user', $user['id_request_user'])->first());
    }
    return $requests;
  }
  /*
    use Notifiable;
    public $timestamps=False;

     * The attributes that are mass assignable.
     *
     * @var array

    protected $fillable = [
        'name', 'email', 'password',
    ];


     * The attributes that should be hidden for arrays.
     *
     * @var array

    protected $hidden = [
        'password', 'remember_token',
    ];
    */
}
