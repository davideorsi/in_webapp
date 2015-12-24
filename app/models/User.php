<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $connection = 'mysql';
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	public function PG() {
		return $this->belongsToMany('PG', 'giocatore-PG', 'user', 'pg');
	}

	public function PNG() {
		return $this->hasMany('PNG', 'Master', 'id')->where('Morto','0');
	}

	public function getRememberToken()
	{
		return $this->remember_token;
	}
	
  
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}
  
	public function getRememberTokenName()
	{
		return "remember_token";
	}

}
