<?php

class DashboardController extends BaseController {

	protected function getStats()
	{
		$stats = [
			'users' => User::count(),
			'servers' => Ssms\Server::count(),
			'active_plugins' => 150, // Plugin::count(),
			'game_types' => 4, // Server::gameTypes()->count(),
		];

		return $stats;
	}

	protected function getServers()
	{
		return ''; //Server::get(['name', 'players']);
	}

	public function getView()
	{
		return View::make('pages.dashboard')
			->with('stats', $this->getStats());
	}

}
