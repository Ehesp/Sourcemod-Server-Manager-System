<?php namespace Ssms\Repositories\Page;

use Ssms\Repositories\EloquentRepository;
use Page;

class EloquentPageRepository extends EloquentRepository implements PageRepository {

	/**
	 * @var app/models/Page
	 */
	protected $model;

	public function __construct(Page $model)
	{
		$this->model = $model;
	}

	public function getWithRoles($id = null)
	{
		if (! is_null($id))
		{
			return $this->model->with('roles')->find($id);
		}

		return $this->model->with('roles')->get();
	}

	public function removeRole($page, $role)
	{
		$page->roles()->detach($role);
	}

	public function assignRole($page, $role)
	{
		$page->roles()->attach($role);
	}
}