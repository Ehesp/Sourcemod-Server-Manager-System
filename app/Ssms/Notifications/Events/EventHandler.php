<?php namespace Ssms\Notifications\Events;

use Ssms\Notifications\Services\ServiceHandler;

class EventHandler {

	protected $handler;

	public function __construct(ServiceHandler $handler)
	{
		$this->handler = $handler;
	}

	public function subscribe($events)
	{
		$events->listen('user.add', 'Ssms\Notifications\Events\EventHandler@onNewUser');
		$events->listen('user.delete', 'Ssms\Notifications\Events\EventHandler@onDeleteUser');
	}

	public function onNewUser($data)
	{
		$type = 'user.add';
		$title = 'New User';
		$message = "User {$data['nickname']} (<a href='http://steamcommunity.com/profiles/{$data['community_id']}'>{$data['community_id']}</a>) has been added!";

		return $this->handler->fire($type, $title, $message);
	}

	public function onDeleteUser()
	{
		//
	}

}