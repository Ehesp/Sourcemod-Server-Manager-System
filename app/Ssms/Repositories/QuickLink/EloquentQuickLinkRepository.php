<?php namespace Ssms\Repositories\QuickLink;

use Ssms\Repositories\EloquentRepository;
use QuickLink;

class EloquentQuickLinkRepository extends EloquentRepository implements QuickLinkRepository {
	
	/**
	 * @var app/models/QuickLink
	 */
	protected $model;

	public function __construct(QuickLink $model)
	{
		$this->model = $model;
	}
}