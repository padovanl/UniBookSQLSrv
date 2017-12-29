<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_make_friends extends Model
{
  protected $table = 'users_make_friends';
  public $timestamps = false;

  //ritorno i record delle amicizie ricevute dall'utente
  public function scopeAskedfriends($query, $id){
        return $query->where('id_request_user', $id)->where('status', 0);
  }

  //ritorno i record delle amicizie richieste dall'utente
  public function scopeRequestfriends($query, $id){
      return $query->where('id_user', $id)->where('status', 0);
  }

  //ritorno i record delle amicizie richieste non ancora accettate
  public function scopePendingrequests($query, $id){
    return $query->where('id_user', $id)->where('status', 1);
  }

  //ritorno i record delle amicizie ricevute non ancora accettate
  public function scopePendingasked($query, $id){
    return $query->where('id_request_user', $id)->where('status', 1);
  }
}
