<?php namespace Ssms\Repositories\User;

interface UserRepositoryInterface {

	public function getAll();

	public function getWithRoles($id);

	public function delete($id);

}