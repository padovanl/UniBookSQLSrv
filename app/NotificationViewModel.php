<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class NotificationViewModel //extends Model
{
    public $id_notification;
    public $content;
    public $picPath;

    public function __constructor($id_notification, $$content, $picPath){
    	$this->id_notification = $id_notification;
    	$this->content = $content;
    	$this->picPath = $picPath;
    }
}
