<?php namespace Ssms\Handlers;

class SettingEventHandler extends Handler {

	public function subscribe($events)
	{
		$events->listen('setting.user.new', 'Ssms\Handlers\SettingEventHandler@onNewUser');
		$events->listen('setting.user.delete', 'Ssms\Handlers\SettingEventHandler@onDeleteUser');
	}

	public function onNewUser()
	{
		$title = 'New User';
		$message = 'A new user has been added to SSMS!';

		$this->fire($title, $message, $user);
	}

	public function onDeleteUser()
	{
		$title = 'User Deleted';
		$message = 'A user has been deleted from SSMS!';

		$this->fire($title, $message, $user);
	}

}