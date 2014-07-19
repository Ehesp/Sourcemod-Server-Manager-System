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

	/**
	* Automatically encrypts a value, based on the name
	*
	*/
	public function setValueAttribute($value)
	{
		if ($this->name == 'twitter.key' || $this->name == 'hipchat.auth')
		{
			 $this->attributes['value'] = \Crypt::encrypt($value);
		}
	}

	/**
	* Automatically decrypts the rcon_password field when called.
	*
	*/
	public function getValueAttribute($value)
	{
		if ($this->name == 'twitter.key' || $this->name == 'hipchat.auth')
		{
			 return \Crypt::decrypt($value);
		}
	    
	}
}