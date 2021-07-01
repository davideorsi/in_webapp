<?php

class Abilita extends Eloquent {

	protected $table = 'Ability';
	public $timestamps = false;
	protected $primaryKey = 'ID';

	public function Requisiti() {
		return $this->belongsToMany('Abilita', 'Ability-Req', 'AB', 'REQ');
	}
	
	public function Esclusi() {
		return $this->belongsToMany('Abilita', 'Ability-Esc', 'AB', 'ESC');
	}

	public function PG() {
		return $this->belongsToMany('PG', 'Ability-PG', 'ID Abil', 'ID PG');
		}

	public function Opzioni() {
		return $this->hasMany('AbilitaOpzioni','Abilita');
		}
}
