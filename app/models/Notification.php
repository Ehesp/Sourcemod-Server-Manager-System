<?php

class Notification extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'notifications';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'friendly_name', 'value', 'options', 'description'];

	/**
	* Using timestamps
	*
	* @var boolen
	*/
	public $timestamps = true;
}