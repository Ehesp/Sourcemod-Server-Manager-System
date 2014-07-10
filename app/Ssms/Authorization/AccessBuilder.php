<?php namespace Ssms\Authorization;

use Role;

class AccessBuilder {

	protected $auth;

	public function __construct($auth)
	{
		$this->auth = $auth;
		$this->pages = $this->getAccessiblePages();
	}

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

	protected function count()
	{
		if (count($this->pages->toArray()) == 0)
		{
			return false;
		}

		return true;
	}

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

	public function pages()
	{
		return $this->pages;
	}
}