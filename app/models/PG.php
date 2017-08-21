<?php

class PG extends Eloquent {

	protected $table = 'PG';
	public $timestamps = false;
	protected $primaryKey = 'ID';		

	public function Abilita() {
		return $this->belongsToMany('Abilita', 'Ability-PG', 'ID PG', 'ID Abil');
	}
	
	public function Incanti() {
		return $this->belongsToMany('Incanto', 'Incanti-PG', 'ID PG', 'ID Incanto');
	}

	public function Categorie() {
		return $this->belongsToMany('Categoria', 'Categorie-PG', 'PG', 'CAT');
	}

	public function Sbloccate() {
		return $this->belongsToMany('Abilita', 'Sbloccate-PG', 'ID PG', 'ID Abil');
	}

	public function User(){
		return $this->belongsTo('Giocatore','ID','pg');	
	}
	
	public function Spese(){
		return $this->hasMany('Spese','PG','ID');
	}	
	public function Conto(){
		return $this->hasMany('Conto','PG','ID');
	}
	
	public function Firme(){
		return $this->hasMany('IDENTITAPG','ID_PG','ID');
	}

	public function Ferite(){
		$pf=2;
		$ab=$this->Abilita()->get();
		$ab=INtools::select_column($ab,'Ability');
		if(in_array('Costituzione debole',$ab)){$pf-=1;}
		if(in_array('Robustezza',$ab)){$pf+=1;}
		if(in_array('Robustezza 2',$ab)){$pf+=1;}
		return $pf;
		}
	public function PxRimasti(){
		return intval($this->Px - $this->Abilita->sum('PX'));
		}
	public function Erbe(){
		return intval($this->Abilita()->sum('Erbe'));
		}
	public function Oggetti(){
		return intval($this->Abilita()->sum('Oggetti'));
		}
	public function Lettere(){
		return intval($this->Abilita()->sum('Lettere'));
		}
	public function Rendita(){
		return intval(2 + $this->Abilita()->sum('Rendita'));
		}

	public function CartelliniPotere(){
		return intval($this->Abilita()->sum('CartelliniPotere'));
		}

	public function Note(){
		return implode('<br>',$this->Abilita()->where('Note','!=','')->lists('Note'));
		}
}
?>
