<?php

use Ssms\Repositories\User\UserRepositoryInterface;

class UserController extends BaseController {

	protected $user;

	public function __construct(UserRepositoryInterface $user)
	{
		$this->user = $user;
	}

	public function getUsers()
	{
		return $this->user->getWithRoles();
	}

}