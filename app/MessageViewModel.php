<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class MessageViewModel //extends Model
{

    public $from; 
    public $to;
    public $picPath;
    public $picPathReceiver;
    public $fromId;
    //tipo 1= inviato 0= ricevuto
    public $tipo;
    public $content;
    public $time;

    function __construct($from, $to, $picPath, $picPathReceiver, $fromId, $tipo, $content, $time){
    	$this->from = $from;
    	$this->to = $to;
    	$this->picPath = $picPath;
    	$this->picPathReceiver = $picPathReceiver;
    	$this->fromId = $fromId;
    	$this->tipo = $tipo;
    	$this->content = $content;
    	$this->time = $time;
    }
}
