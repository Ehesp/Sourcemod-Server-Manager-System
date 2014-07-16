<?php

class Trigger extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'triggers';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'friendly_name', 'value', 'options', 'description'];
}