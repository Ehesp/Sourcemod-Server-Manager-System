<?php namespace Ssms\Repositories\Service;

interface ServiceRepository {

	/**
	 * Get all of the services and their details
	 *
	 * @return object
	 */
	public function getAll();

	public function getFirst($type, $value, $operator);

}