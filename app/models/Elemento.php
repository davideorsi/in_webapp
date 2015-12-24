<?php

class Elemento extends \Eloquent {


	protected $connection = 'sqlite';
	public $timestamps = false;
	protected $primaryKey = 'ID';
	// Add your validation rules here
	public static $rules = [
		'text' => 'required',
		'vicenda' => 'required',
		'start'=> 'required',
		'end'	=> 'required'
	];
	
	public function PNG() {
		$pngs=$this->belongsToMany('PNG','Elemento-PNG','ID Elemento','ID PNG');
		
		return $pngs;
	}
	
	public function PNGminori() {
		return $this->hasMany('ElementoPNGminori','Elemento');
	}

	// Don't forget to fill this array
	protected $fillable = ['text','data','vicenda','start','end'];

}
