<?php

class GameType extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'game_types';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $guarded = ['id'];

	/**
	* Disable timestamps on this model
	*
	* @var boolen
	*/
	public $timestamps = false;

	/**
	* Many-One relationship with the servers table
	*
	*/
	public function servers()
    {
        return $this->hasMany('Ssms\Server', 'client_appid', 'client_appid');
    }
}