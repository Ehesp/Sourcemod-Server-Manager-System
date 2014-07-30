<?php namespace Ssms\Notifications\Services;

use Ssms\Repositories\Event\EventRepository;
use Ssms\Repositories\Notification\NotificationRepository;

abstract class ServiceData {

	protected $events;

	protected $notifications;

	public function __construct(EventRepository $events, NotificationRepository $notifications)
	{
		$this->events = $events;
		$this->notifications = $notifications;
	}

	public function getServices($type)
	{
		$event = $this->events->getFirst('name', $type);

		$event = $this->events->getWithServices($event['id']);

		return $event->services;
	}

	public function getSettings($type)
	{
		return $this->notifications->getTypeSettings($type);
	}

}