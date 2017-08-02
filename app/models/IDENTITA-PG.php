<?php
class IDENTITAPG extends Eloquent {

	protected $table = 'IDENTITA-PG';
	public $timestamps = false;
	protected $primaryKey = 'ID';	
	
	public function PG(){
		return $this->belongsTo('PG','ID_PG','ID');	
	}	

}
?>
