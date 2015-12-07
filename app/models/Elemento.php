<?php

class Elemento extends \Eloquent {

	public $timestamps = false;
	protected $primaryKey = 'ID';
	// Add your validation rules here
	public static $rules = [
		'text' => 'required',
		'vicenda' => 'required',
		'start'=> 'required',
		'end'	=> 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['text','data','vicenda','start','end'];

}
