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
	* Get pages and their access
	*
	* @return json
	*/
	public function getPages()
	{
		return Page::with('roles')->get();
	}

	/**
	* Edit a page
	*
	* Takes a AJAX post request.
	* @return json
	*/
	protected function editPage()
	{
		$page = Input::all();

		// If no icon given
		if ($this->isEmpty($page['edit']['icon'])) return $this->jsonResponse(400, false, "The icon field cannot be left empty!");

		// If invalid font awesome name 
		if (! $this->isValidFontAwesome($page['edit']['icon'])) return $this->jsonResponse(400, false, "The icon name supplied is not a valid Font Awesome icon!");

		// Page must have a role attached
		if (count($page['edit']['role']) == 0) return $this->jsonResponse(400, false, "A page must have at least one role!");

		// Stop user assigning User/Guest role to settings and multi_console page
		if ($page['name'] == 'settings' || $page['name'] == 'multi_console')
		{
			foreach ($page['edit']['role'] as $role)
				if ($role['name'] == 'user' || $role['name'] == 'guest') return $this->jsonResponse(400, false, "Unable to give page User or Guest privilages for security reasons!");
		}

		try
		{
			$update = Page::find($page['id']);

			$update->icon = $page['edit']['icon'];
			$update->save();

			// Remove all page roles
			$update->roles()->detach();

			//Give page new set of chosen roles
			foreach ($page['edit']['role'] as $role)
			{
				$update->assignRoles(
					Role::where('name', $role['name'])->get()
				);
			}
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Page successfully updated!', Page::with('roles')->find($page['id']));

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
		return Permission::all();
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
			->with('page_access', $this->getPages())
			->with('permission_control', $this->getPermissions())
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