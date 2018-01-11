<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class PostViewModel //extends Model
{

    public $id_post;
    public $auth_name;
    public $auth_surname;
    public $pic_path;
    public $content;
    public $created_at;
    public $updated_at;
    public $fixed;
    public $id_auth;
    public $comments;
    public $likes;
    public $dislike;
    public $userlike;
    public $ban;

    public function __construct($id_post, $auth_name, $auth_surname, $pic_path, $content, $created_at, $updated_at, $fixed, $id_auth, $comments, $likes, $dislike, $userlike, $ban) {
       $this->id_post = $id_post;
       $this->auth_name = $auth_name;
       $this->auth_surname = $auth_surname;
       $this->pic_path = $pic_path;
       $this->content = $content;
       $this->created_at = $created_at;
       $this->updated_at = $updated_at;
       $this->fixed = $fixed;
       $this->id_auth = $id_auth;
       $this->comments = $comments;
       $this->likes = $likes;
       $this->dislike = $dislike;
       $this->userlike = $userlike;
       $this->ban = $ban;
   }
}

?>
