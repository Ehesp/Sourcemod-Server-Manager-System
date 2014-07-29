<?php namespace Ssms\Repositories\Event;

use Ssms\Repositories\EloquentRepository;
use Ssms\Event as Event;

class EloquentEventRepository extends EloquentRepository implements EventRepository {

	/**
	 * @var app/models/Event
	 */
	protected $model;

	public function __construct(Event $model)
	{
		$this->model = $model;
	}

	public function getWithServices($id = null)
	{
		if (! is_null($id))
		{
			return $this->model->with('services')->find($id);
		}

		return $this->model->with('services')->get();
	}

	public function removeService($event, $service)
	{
		$event->services()->detach($service);
	}

	public function assignService($event, $service)
	{
		$event->services()->attach($service);
	}
}