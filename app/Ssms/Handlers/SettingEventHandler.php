<?php namespace Ssms\Handlers;

class SettingEventHandler extends Handler {

	public function subscribe($events)
	{
		$events->listen('setting.user.new', 'Ssms\Handlers\SettingEventHandler@onNewUser');
		$events->listen('setting.user.delete', 'Ssms\Handlers\SettingEventHandler@onDeleteUser');
		$events->listen('setting.user.update', 'Ssms\Handlers\SettingEventHandler@onUpdateUser');

		$events->listen('setting.option.update', 'Ssms\Handlers\SettingEventHandler@onUpdateOption');

		$events->listen('setting.page.update', 'Ssms\Handlers\SettingEventHandler@onUpdatePage');

		$events->listen('setting.permission.update', 'Ssms\Handlers\SettingEventHandler@onUpdatePermission');

		$events->listen('setting.quick-link.update', 'Ssms\Handlers\SettingEventHandler@onUpdateQuickLink');
	}

	public function onNewUser()
	{
		// user added
	}

	public function onDeleteUser()
	{
		// user removed
	}

	public function onUpdateUser()
	{
		// user updated
	}

	public function onUpdateOption()
	{
		// option updated
	}

	public function onUpdatePage()
	{
		// page updated
	}

	public function onUpdatePermission()
	{
		// permission updated
	}

	public function onUpdateQuickLink()
	{
		// permission updated
	}
}