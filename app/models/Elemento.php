<?php

class Elemento extends \Eloquent {

	public $timestamps = false;
	protected $primaryKey = 'ID';
	// Add your validation rules here
	public static $rules = [
		'title' => 'required',
		'vicenda' => 'required',
		'inizio'=> 'required',
		'fine'	=> 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['title','body','vicenda','inizio','fine'];

}
