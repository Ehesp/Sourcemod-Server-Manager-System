<?php namespace Ssms\Notifications\Services;

use Ssms\Services\HipChat\HipChatService;

class ServiceHandler extends ServiceData {

	public function fire($type, $title, $message)
	{
		$services = $this->getServices($type);

		foreach ($services as $service) $this->{$service->name}($title, $message);
	}

	protected function isEnabled($type, $settings)
	{
		foreach ($settings as $item)
		{
			if ($item->name == "{$type}.enabled")
			{
				return ($item->value == 'true');
			}
		}

		return false;
	}

	protected function email($title, $message)
	{
		// Send Email
	}

	protected function twitter($title, $message)
	{
		// Send Tweet
	}

	protected function hipchat($title, $message)
	{
		$settings = $this->getSettings(__FUNCTION__);
		
		if ($this->isEnabled(__FUNCTION__, $settings))
		{
			foreach ($settings as $item)
			{
				if ($item->name == 'hipchat.room') $room = $item->value;
				if ($item->name == 'hipchat.auth') $auth = $item->value;
			}

			try
			{
				$hipchat = new HipChatService($room, $auth);
				$hipchat->send($title, $message);
			}
			catch (Exception $e)
			{
				// Log
			}
		}
	}

	protected function pushbullet($title, $message)
	{
		// Send
	}

}