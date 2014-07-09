<?php namespace Ssms\Authorization;

class Access {

	public function checkPageAccess($pages, $url)
	{
		$access = false;

		foreach ($pages as $page)
		{
			if ($page->slug == $url)
			{
				$access = true;
				break;
			}
		}

		if (! $access) {
			\App::abort(401, 'Unauthorized access');
		}

		return $access;
	}
}