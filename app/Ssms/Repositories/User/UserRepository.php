<?php namespace Ssms\Repositories\User;

interface UserRepository {

	/**
	 * Get the count of users 
	 *
	 * @return int
	 */
	public function count();

	/**
	 * Get all of the users and their details
	 *
	 * @return object
	 */
	public function getAll();

	/**
	 * Get all of the users and their details with attached roles
	 *
	 * @return object
	 */
	public function getWithRoles($id);

	/**
	 * Add a user to the database
	 *
	 * @param array $array Array of fields to add data to
	 * @return object
	 */
	public function add($array);

	/**
	 * Delete a user from the database
	 *
	 * @param int $id
	 * @return void
	 */
	public function delete($id);

	/**
	 * Edit a user with a given array
	 *
	 * @param int $id
	 * @param array $array
	 * @return object
	 */
	public function edit($id, $array);

	/**
	 * Remove all user roles
	 *
	 * @param object $user
	 * @return void
	 */
	public function removeRole($user, $role);

	/**
	 * Assign a user a role
	 *
	 * @param object $role
	 * @return void
	 */
	public function assignRole($user, $role);
}