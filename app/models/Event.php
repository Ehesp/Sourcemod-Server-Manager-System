<?php namespace Ssms;

use Eloquent;

/**
* This class is namespaced due to a class conflict naming with the
* Laravel Event class
*
* Usage: Ssms\Event::method();
*
* @var string
*/

class Event extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'events';

	/**
	* The guarded table columns.
	*
	* @var array
	*/
	protected $fillable = ['name', 'description'];

	/**
	* Using timestamps
	*
	* @var boolen
	*/
	public $timestamps = true;

	/**
	* 
	*
	*/
	public function services()
	{
		return $this->belongsToMany('Service', 'event_service');
	}

	public function assignServices($services)
	{
		foreach ($services as $service)
		{
			$this->services()->attach($service);
		}
	}
}