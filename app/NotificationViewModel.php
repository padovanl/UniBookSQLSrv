<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class NotificationViewModel //extends Model
{
    public $id_notification;
    public $content;
    public $picPath;
    public $link;
    public $new;

    function __construct($id_notification, $content, $picPath, $link, $new){
    	$this->id_notification = $id_notification;
    	$this->content = $content;
    	$this->picPath = $picPath;
    	$this->link = $link;
    	$this->new = $new;
    }
}
