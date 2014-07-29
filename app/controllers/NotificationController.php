<?php

use Ssms\Repositories\Notification\NotificationRepository;
use Ssms\Repositories\Event\EventRepository;
use Ssms\Repositories\Service\ServiceRepository;

class NotificationController extends BaseController {

	/**
	 * @var $notifications NotificationRepository
	 */
	protected $notifications;

	/**
	 * @var $events EventRepository
	 */
	protected $events;

	/**
	 * @var $events ServiceRepository
	 */
	protected $services;

	public function __construct(NotificationRepository $notifications, EventRepository $events, ServiceRepository $services)
	{
		$this->notifications = $notifications;
		$this->events = $events;
		$this->services = $services;
	}

	public function get()
	{
		return $this->notifications->getAll();
	}

	public function edit()
	{
		$data = Input::all();

		if ($data['name'] == 'retries' && ! ctype_digit($data['value'])) return $this->jsonResponse(400, false, "Please enter a valid integer number!");

		if ($data['name'] == 'retries' && intval($data['value']) < 3) return $this->jsonResponse(400, false, "The minimum retry time is 3 minutes!");

		if ($data['name'] == 'email.addresses' && ! $this->isValidEmails($data['value'])) return $this->jsonResponse(400, false, "An email address entered is not valid!");

		try
		{
			$notification = $this->notifications->edit($data['id'], ['value' => $data['value']]);
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'The notification setting has been updated!', $notification);
	}

	public function getEvents()
	{
		return $this->events->getWithServices();
	}

	public function editEvent()
	{
		$data = Input::all();

		try
		{
			$services = $this->services->getAll();

			$event = $this->events->getFirst('id', $data['id']);

			foreach ($services as $service)
			{
				$this->events->removeService($event, $service['id']);
			}

			foreach ($data['edit']['service'] as $service)
			{
				$this->events->assignService($event, $service['id']);
			}
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'The event has been updated!', $this->events->getWithServices($data['id']));
	}

}