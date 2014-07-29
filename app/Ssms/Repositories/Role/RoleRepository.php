<?php namespace Ssms\Repositories\Role;

interface RoleRepository {

	public function getAll();

	public function getBy($type, $value, $operator);

	public function getFirst($type, $value, $operator);

}