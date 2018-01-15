<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;

class PageListViewModel //extends Model
{
	public $name;
	public $id_user;
	public $picPath;
	public $id_page;

	function __construct($name, $id_user, $picPath, $id_page){
		$this->$name = $name;
		$this->id_user = $id_user;
		$this->picPath = $picPath;
		$this->id_page = $id_page;
	}
}
