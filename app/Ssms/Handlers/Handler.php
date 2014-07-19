<?php namespace Ssms\Handlers;

use Notification;

class Handler {

	public function __construct()
	{
		$this->notifications = Notification::get(['name', 'value']);
		$this->events = \Ssms\Event::with('services')->get();
	}

	protected function fire($title, $message, $data)
	{
		//
	}

	protected function sendEmail()
	{
		//
	}

	protected function sendTweet()
	{
		//
	}

	protected function sendHipchat()
	{
		//
	}

	protected function sendPushbullet()
	{
		//
	}

}