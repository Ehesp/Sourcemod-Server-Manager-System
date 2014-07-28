<?php

use Ssms\Repositories\User\UserRepository;
use Ssms\Repositories\Permission\PermissionRepository;

class SettingController extends BaseController {

	protected $users;

	protected $permissions;

	public function __construct(UserRepository $users, PermissionRepository $permissions)
	{
		$this->users = $users;
		$this->permissions = $permissions;
	}

	public function getPages()
	{
		return Page::with('roles')->get();
	}

	/**
	* Get all options
	*
	* @return json
	*/
	public function getOptions()
	{
		return Option::all();
	}

	/**
	* Get quick links
	*
	* @return json
	*/
	protected function getQuickLinks()
	{
		return QuickLink::all();
	}



	/**
	* Get the application notification options
	*
	* @return json
	*/
	public function getNotifications()
	{
		return Notification::all();
	}

	/**
	* Get the application events with their services
	*
	* @return json
	*/
	public function getEvents()
	{
		return Ssms\Event::with('services')->get();
	}

	/**
	* Edit an notification
	*
	* Takes a AJAX post request.
	* @return json
	*/
	public function editNotification()
	{
		$notification = Input::all();

		if ($this->isEmpty($notification['value'])) return $this->jsonResponse(400, false, "The option value must be present!");

		if ($notification['name'] == 'retries' && ! ctype_digit($notification['value'])) return $this->jsonResponse(400, false, "Please enter a valid integer number!");

		if ($notification['name'] == 'retries' && intval($notification['value']) < 3) return $this->jsonResponse(400, false, "The minimum retry time is 3 minutes!");

		if ($notification['name'] == 'email.addresses' && ! $this->isValidEmails($notification['value'])) return $this->jsonResponse(400, false, "An email address entered is not valid!");

		try
		{
			$update = Notification::find($notification['id']);
			$update->value = $notification['value'];
			$update->save();
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'The notification setting has been updated!', $update);
	}

	/**
	* Edit an notification
	*
	* Takes a AJAX post request.
	* @return json
	*/
	public function saveEvent()
	{
		$event = Input::all();

		try
		{
			$update = Ssms\Event::find($event['id']);

			// Remove all services
			$update->services()->detach();

			// Update new roles
			foreach ($event['edit']['service'] as $service) {
				$update->assignServices(
					Service::where('id', $service['id'])->get()
				);
			}

			$update->save();
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'The event has been updated!', Ssms\Event::with('services')->find($event['id']));
	}

	public function getPermissions()
	{
		return Permission::with('page')->get();
	}

	/**
	* Return the master settings overview with data
	*
	* @return View
	*/
	public function getView()
	{
		return View::make('pages.settings')
			->with('users', $this->users->getWithRoles())
			->with('options', $this->getOptions())
			->with('pages', $this->getPages())
			->with('permissions', $this->getPermissions())
			->with('quick_links', $this->getQuickLinks())
			->with('notifications', $this->getNotifications());
	}

	/**
	* Return the users settings view
	*
	* @return View
	*/
	public function getUsersView()
	{
		return View::make('pages.settings.users');
	}

	/**
	* Return the options settings view
	*
	* @return View
	*/
	public function getOptionsView()
	{
		return View::make('pages.settings.options');
	}

	/**
	* Return the page-access settings view
	*
	* @return View
	*/
	public function getPageManagementView()
	{
		return View::make('pages.settings.page-management');
	}

	/**
	* Return the permission-control settings view
	*
	* @return View
	*/
	public function getPermissionControlView()
	{
		return View::make('pages.settings.permission-control');
	}

	/**
	* Return the quick-links settings view
	*
	* @return View
	*/
	public function getQuickLinksView()
	{
		return View::make('pages.settings.quick-links');
	}

	/**
	* Return the notifications settings view
	*
	* @return View
	*/
	public function getNotificationsView()
	{
		return View::make('pages.settings.notifications');
	}
}