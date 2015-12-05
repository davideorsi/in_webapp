<?php

class Trama extends \Eloquent {


	public $timestamps = false;
	protected $primaryKey = 'ID';
	// Add your validation rules here
	public static $rules = [
		'title' => 'required',
		'body' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['title','body'];

}
