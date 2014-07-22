<?php namespace Ssms\Repositories\Role;

interface RoleRepositoryInterface {

	public function getBy($type, $value, $operator);

	public function getFirst($type, $value, $operator);

}