<?php namespace Ssms\Authorization;

use Role;

class AccessBuilder {

	/**
	 * The $app->auth instance
	 *
	 */
	protected $auth;

	/**
	 * Create a new AccessBuilder instance.
	 *
	 * @return void
	 */
	public function __construct($auth)
	{
		$this->auth = $auth;
		$this->pages = $this->getAccessiblePages();
	}

	/**
	 * Returns the pages which are accessible to the user in their
	 * current authenticated state.
	 * 
	 * @return json
	 */
	private function getAccessiblePages()
	{
		if ($this->auth->guest())
		{
			return Role::whereName('guest')->first()->pages;
		}
		else
		{
			return $this->auth->user()->pages;
		}
	}

	/**
	 * Determins whether the user has any pages to access.
	 * 
	 * @return bool
	 */
	protected function count()
	{
		if (count($this->pages->toArray()) == 0)
		{
			return false;
		}

		return true;
	}

	/**
	 * Validates whether the given user has access
	 * to a given page
	 * 
	 * @return bool
	 */
	public function validate($value, $type = 'slug')
	{
		$access = false;

		if ($this->count())
		{
			foreach ($this->pages as $page)
			{
				if ($page->$type == $value)
				{
					$access = true;
					break;
				}
			}
		}
		
		return $access;
	}

	/**
	 * Returns the pages the user is able to access
	 * 
	 * @return json
	 */
	public function pages()
	{
		return $this->pages;
	}
}