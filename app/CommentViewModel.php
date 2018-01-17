<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class CommentViewModel //extends Model
{
    public $id_comment;
    public $auth_name;
    public $auth_surname;
    public $pic_path;
    public $content;
    public $created_at;
    public $updated_at;
    public $id_post;
    public $is_blocked;
    public $likes;
    public $dislikes;
    public $userlike;
    public $id_author;
    public $ban;

    public function __construct($id_comment, $auth_name, $auth_surname, $pic_path, $content, $created_at, $updated_at, $id_post, $likes, $dislikes, $userlike, $id_user, $ban) {
       $this->id_comment = $id_comment;
       $this->auth_name = $auth_name;
       $this->auth_surname = $auth_surname;
       $this->pic_path = $pic_path;
       $this->content = $content;
       $this->created_at = $created_at;
       $this->updated_at = $updated_at;
       $this->id_post = $id_post;
       $this->likes = $likes;
       $this->dislikes = $dislikes;
       $this->userlike = $userlike;
       $this->id_author = $id_user;
       $this->ban = $ban;
   }
}

?>
