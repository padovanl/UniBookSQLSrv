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
    public $created_at;
    public $totNotifiche;

    function __construct($id_notification, $content, $picPath, $link, $new, $created_at, $totNotifiche){
    	$this->id_notification = $id_notification;
    	$this->content = $content;
    	$this->picPath = $picPath;
    	$this->link = $link;
    	$this->new = $new;
        $this->created_at = $created_at;
        $this->totNotifiche = $totNotifiche;
    }
}
