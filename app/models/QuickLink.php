<?php

class QuickLink extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'quick_links';

	/**
	* The fillable table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'url', 'icon'];

	/**
	* Disable timestamps on this model
	*
	* @var boolen
	*/
	public $timestamps = false;
}