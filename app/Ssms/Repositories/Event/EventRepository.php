<?php namespace Ssms\Repositories\Event;

interface EventRepository {

	public function getWithServices($id);

	public function getFirst($type, $value);

	public function removeService($event, $service);

	public function assignService($event, $service);

}