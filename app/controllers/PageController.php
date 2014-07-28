<?php

use Ssms\Repositories\Page\PageRepository;
use Ssms\Repositories\Role\RoleRepository;

class PageController extends BaseController {

	/**
	 * @var $pages PageRepository
	 */
	protected $pages;

	/**
	 * @var RoleRepository
	 */
	protected $roles;

	public function __construct(PageRepository $pages, RoleRepository $roles)
	{
		$this->pages = $pages;
		$this->roles = $roles;
	}

	public function get()
	{
		return $this->pages->getWithRoles();
	}

	public function edit()
	{
		$data = Input::all();

		// If no icon given
		if ($this->isEmpty($data['edit']['icon'])) return $this->jsonResponse(400, false, "The icon field cannot be left empty!");

		// If invalid font awesome name 
		if (! $this->isValidFontAwesome($data['edit']['icon'])) return $this->jsonResponse(400, false, "The icon name supplied is not a valid Font Awesome icon!");

		// Page must have a role attached
		if (count($data['edit']['role']) == 0) return $this->jsonResponse(400, false, "A page must have at least one role!");

		try
		{
			$page = $this->pages->edit($data['id'], ['icon' => $data['edit']['icon']]);

			$roles = $this->roles->getAll();

			foreach ($roles as $role)
			{
				$this->pages->removeRole($page, $role['id']);
			}

			//Give page new set of chosen roles
			foreach ($data['edit']['role'] as $role)
			{
				$this->pages->assignRole($page, $role['id']);
			}
		}
		catch (Exception $e)
		{
			return $this->jsonResponse(400, false, $e->getMessage());
		}

		return $this->jsonResponse(200, true, 'Page successfully updated!', $this->pages->getWithRoles($data['id']));
	}

}