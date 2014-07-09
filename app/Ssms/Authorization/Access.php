<?php namespace Ssms\Authorization;

class Access {

	protected $pages = [];

	public function __construct($pages)
	{
		$this->pages = $pages->toArray();
	}

	public function validate($segment)
	{
		$access = false;

		if ($this->count($this->pages))
		{
			foreach ($this->pages as $page)
			{
				if ($page['slug'] == $segment)
				{
					$access = true;
					break;
				}
			}

		}
		
		return $access;
	}

	protected function count($pages)
	{
		if (count($pages) == 0)
		{
			return false;
		}

		return true;
	}
}