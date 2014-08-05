<?php namespace Ssms\Repositories\Server;

use Ssms\Repositories\EloquentRepository;
use Ssms\Server as Server;

class EloquentServerRepository extends EloquentRepository implements ServerRepository {

	/**
	 * @var app/models/Server
	 */
	protected $model;

	public function __construct(Server $model)
	{
		$this->model = $model;
	}

	public function hasDuplicate($ip, $port)
	{
		return $this->model->where('ip', $ip)->where('port', $port)->first();
	}

	public function getServerDetails($id)
	{
		return $this->model->where('id', $id)->first(['ip', 'port', 'rcon_password']);
	}

	

}