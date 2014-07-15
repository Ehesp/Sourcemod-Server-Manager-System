<?php namespace Ssms;

use Eloquent;

/**
* This class is namespaced due to a class conflict naming with the
* steam condenser package.
*
* Usage: Ssms\Server::method();
*
* @var string
*/

class Server extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'servers';

	/**
	* The guarded table columns.
	*
	* @var array
	*/
	protected $guarded = ['id', 'rcon_password'];

	/**
	* Automatically encrypts a value entered into the rcon_password field.
	*
	*/
	public function setRconPasswordAttribute($value)
	{
	    $this->attributes['rcon_password'] = \Crypt::encrypt($value);
	}

	/**
	* Automatically decrypts the rcon_password field when called.
	*
	*/
	public function getRconPasswordAttribute($value)
	{
	    return \Crypt::decrypt($value);
	}
}