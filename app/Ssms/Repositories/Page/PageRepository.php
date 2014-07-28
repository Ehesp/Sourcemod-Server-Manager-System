<?php namespace Ssms\Repositories\Page;

interface PageRepository {

	public function getWithRoles($id);

	public function removeRole($page, $role);
	
	public function assignRole($page, $role);
	
}