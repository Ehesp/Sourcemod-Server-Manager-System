<?php

class Service extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'services';

	/**
	* The guarded table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'friendly_name'];

	/**
	* Using timestamps
	*
	* @var boolen
	*/
	public $timestamps = false;

	/**
	* 
	*
	*/
	public function events()
	{
		return $this->belongsToMany('Ssms\Event', 'event_service');
	}
}
