<?php namespace Ssms\Repositories\Server;

interface ServerRepository {

	/**
	 * Get all of the services and their details
	 *
	 * @return object
	 */
	public function getAll($select);

	public function getFirst($type, $value, $operator);

	public function hasDuplicate($ip, $port);

}