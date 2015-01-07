<?php

class PNG extends Eloquent {

	protected $table = 'PNG';
	public $timestamps = false;
	protected $primaryKey = 'ID';		

	public function Abilita() {
		return $this->belongsToMany('Abilita', 'Ability-PNG', 'ID PNG', 'ID Abil');
	}
	
	public function Incanti() {
		return $this->belongsToMany('Incanto', 'Incanti-PNG', 'ID PNG', 'ID Incanto');
	}

	public function Categorie() {
		return $this->belongsToMany('Categoria', 'Categorie-PNG', 'PNG', 'CAT');
	}

	public function Px(){
		return $this->Abilita->sum('PX');
		}
	public function Erbe(){
		return $this->Abilita()->sum('Erbe');
		}
	public function Rendita(){
		return 2 + $this->Abilita()->sum('Rendita');
		}

	public function CartelliniPotere(){
		return $this->Abilita()->sum('CartelliniPotere');
		}

}
?>
