<?php

class PreziosiOfferte extends Eloquent {

	protected $table = 'PreziosiOfferte';
	public $timestamps = false;
	protected $primaryKey = 'ID';
	
	public function PG(){
		return $this->belongsTo('PG','ID_PG','ID');	
	}
}
