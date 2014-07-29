<?php

use Ssms\Repositories\User\UserRepository;
use Ssms\Repositories\Permission\PermissionRepository;
use Ssms\Repositories\Page\PageRepository;
use Ssms\Repositories\Option\OptionRepository;
use Ssms\Repositories\QuickLink\QuickLinkRepository;
use Ssms\Repositories\Notification\NotificationRepository;

class SettingController extends BaseController {

	/**
	 * @var $users UserRepository
	 */
	protected $users;

	/**
	 * @var $permissions PermissionRepository
	 */
	protected $permissions;

	/**
	 * @var $pages PageRepository
	 */
	protected $pages;	

	/**
	 * @var $options OptionRepository
	 */
	protected $options;	

	/**
	 * @var $quicklinks QuickLinkRepository
	 */
	protected $quicklinks;	

	/**
	 * @var $notifications NotificationRepository
	 */
	protected $notifications;

	public function __construct(UserRepository $users, PermissionRepository $permissions, PageRepository $pages, OptionRepository $options, QuickLinkRepository $quicklinks, NotificationRepository $notifications)
	{
		$this->users = $users;
		$this->permissions = $permissions;
		$this->pages = $pages;
		$this->options = $options;
		$this->quicklinks = $quicklinks;
		$this->notifications = $notifications;
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
			->with('options', $this->options->getAll())
			->with('pages', $this->pages->getWithRoles())
			->with('permissions', $this->permissions->getWithRolesPage())
			->with('quick_links', $this->quicklinks->getAll())
			->with('notifications', $this->notifications->getAll());
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