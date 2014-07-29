<?php namespace Ssms\Repositories\Service;

use Ssms\Repositories\EloquentRepository;
use Service;

class EloquentServiceRepository extends EloquentRepository implements ServiceRepository {

	/**
	 * @var app/models/Service
	 */
	protected $model;

	public function __construct(Service $model)
	{
		$this->model = $model;
	}

}