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
	* The fillable table columns.
	*
	* @var array
	*/
	protected $guarded = ['id'];
}