<?php

class Vicenda extends \Eloquent {

	public $timestamps = false;
	protected $primaryKey = 'ID';
	// Add your validation rules here
	public static $rules = [
		'title' => 'required',
		'body'  => 'required',
		'live'  => 'required'
	];
	
	public function Evento(){
		return $this->hasOne('Evento','ID','live');
	}

	public function Trama(){
		return $this->hasOne('Trama','ID','trama');
	}
	
	public function Elementi() {
		return $this->hasMany('Elemento', 'vicenda', 'ID');
	}

	protected $fillable = array('title', 'body', 'live', 'trama');
}
