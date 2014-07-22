<?php namespace Ssms\Repositories\Option;

use Ssms\Repositories\EloquentRepository;
use Option;

class EloquentOptionRepository extends EloquentRepository implements OptionRepositoryInterface {

	/**
	 * @var app/models/Option
	 */
	protected $model;

	public function __construct(Option $model)
	{
		$this->model = $model;
	}
}