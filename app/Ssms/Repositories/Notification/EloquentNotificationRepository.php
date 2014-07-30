<?php namespace Ssms\Repositories\Notification;

use Ssms\Repositories\EloquentRepository;
use Notification;

class EloquentNotificationRepository extends EloquentRepository implements NotificationRepository {

	/**
	 * @var app/models/Notification
	 */
	protected $model;

	public function __construct(Notification $model)
	{
		$this->model = $model;
	}

	public function getServicesState()
	{
		return $this->model->services()->get(['name', 'value']);
	}

	public function getTypeSettings($type)
	{
		return $this->model->where('name', 'LIKE', "{$type}.%")->get(['name', 'value']);
	}
}