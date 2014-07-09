<?php namespace Ssms\Authorization;

class Count {

	public function checkPageCount($pages)
	{
		$pages = $pages->toArray();

		if (count($pages) == 0)
		{
			\App::abort(403, 'No pages to access');
		}

		return;
	}
}