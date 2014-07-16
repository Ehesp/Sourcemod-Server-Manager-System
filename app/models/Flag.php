<?php

class Flag extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'flags';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $fillable = ['icon', 'type', 'message'];

	/**
	* Disable timestamps on this model
	*
	* @var boolen
	*/
	public $timestamps = false;

    public function servers()
    {
        return $this->hasMany('Ssms\Server', 'flag', 'id');
    }
}