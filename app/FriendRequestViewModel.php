<?php

namespace App;

class FriendRequestViewModel{
	public $id_request;
	public $id_user;
	public $id_request_user;
	public $new;
	public $content;
	public $link;
	public $user;

	 public function __construct($id_request, $id_user, $id_request_user, $new, $content, $link, $user){
	 	$this->id_request = $id_request;
	 	$this->id_user = $id_user;
	 	$this->id_request_user = $id_request_user;
	 	$this->new = $new;
	 	$this->content = $content;
	 	$this->link = $link;
	 	$this->user = $user;
	 }
}