<?php namespace Ssms\Services\HipChat;

use HipChat\HipChat;
use Ssms\Services\ServiceInterface;

class HipChatService implements ServiceInterface {

	protected $roomId;

	protected $token;

	public function __construct($roomId, $token)
	{
		$this->room = $roomId;
		$this->init($token);
	}

	protected function init($token)
	{
		$this->hipchat = new HipChat($token);
		$this->hipchat->set_verify_ssl(false);

		return $this;
	}

	public function send($title = 'SSMS', $message)
	{
		$this->hipchat->message_room($this->room, $title, $message);
	}

}