app.controller('ServersCtrl', function($scope, $rootScope, dialogs, http, toasty)
{
	var refreshTime = 60;

	$scope.loading = true;
	$scope.error = false;

	$rootScope.servers = {};

	/**
	* Load SSMS servers
	*/

	function servers()
	{
		http.post(window.app_path + 'servers').
			success(function(data)
			{
				$rootScope.servers = data;
				$scope.loading = false;
			}).
			error(function(data, status, headers, config)
			{
				$scope.message = errorExceptionMessage(data, status, config);
				$scope.error = true;
				$scope.loading = false;
			});
	}

	servers();

	/**
	* Add server function
	* Load newServerDialogCtrl dialog
	*/ 
	$scope.addServer = function()
	{
		dialogs.create(window.app_path + 'templates/secure/servers.add', 'newServerDialogCtrl',{});
	}

	/**
	* View server players (real time)
	* Load viewServerPlayersCtrl dialog
	*/ 
	$scope.viewPlayers = function(id)
	{
		dialogs.create(window.app_path + 'templates/servers.view_players', 'viewPlayersCtrl', id);
	}
})

.controller('viewPlayersCtrl', function($scope, $rootScope, $modalInstance, data, http, toasty)
{
	$scope.loading = true;
	$scope.error = false;
	$scope.players = {};

	http.post(window.app_path + 'servers/players/' + data).
		success(function(data)
		{
			$scope.players = data;
			$scope.loading = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.error = true;
			$scope.loading = false;
		});

	/**
	* Close the dialog
	*/ 
	$scope.close = function()
	{
		$modalInstance.dismiss();
	};
})

.controller('newServerDialogCtrl', function($scope, $rootScope, $modalInstance, data, http, toasty)
{
	function reset()
	{
		$scope.server = {};
		$scope.options = {};

		$scope.errorStatus = '';
		$scope.addStatus = '';
		$scope.errorType = '';
		$scope.message = '';

		$scope.searching = false;
		$scope.adding = false;

		$scope.bools = [{'value': 0, 'name': 'false'},{'value': 1, 'name': 'true'}];

		$scope.dailyRestartEnabled = false;
	}

	reset();

	$scope.search = function(server)
	{
		if (! angular.isDefined(server.ip) || ! validateIp(server.ip) && ! validateHost(server.ip))
		{
			$scope.errorStatus = 'warning';
			$scope.errorType = 'ip';

			$scope.message = 'Please enter a valid hostname or IP address!';
		}
		else if(! angular.isDefined(server.port) || ! validateNumber(server.port))
		{
			$scope.errorStatus = 'warning';
			$scope.errorType = 'port';

			$scope.message = 'Please enter a valid port number!';
		}
		else if(! angular.isDefined(server.rcon) || server.rcon == '')
		{
			$scope.errorStatus = 'warning';
			$scope.errorType = 'rcon';

			$scope.message = 'Please enter an RCON password!';
		}
		else
		{
			$scope.errorStatus = '';
			$scope.errorType = '';
			$scope.message = '';

			$scope.searching = true;

			// Send request to search for server
			http.post(window.app_path + 'servers/add/search', JSON.stringify(server)).
				success(function(data)
				{
					$scope.searching = false;

					if(! data.status)
					{
						$scope.errorStatus = 'error';
						$scope.message = data.message;
					}
					else
					{
						$scope.errorStatus = 'success';
						$scope.message = data.message;

						$scope.newServer = data.payload.server;
						$scope.newServer.ip = server.ip;
						$scope.newServer.port = server.port;
						$scope.newServer.rcon = server.rcon;

						$scope.options.companion = data.payload.options[findWithAttr(data.payload.options, 'name', 'companion_script')].value;
					}
				}).
				error(function(data, status, headers, config)
				{
					$scope.searching = false;

					$scope.errorStatus = 'error';
					$scope.message = errorExceptionMessage(data, status, config);
				});
		}

		$scope.dailyRestartToggle = function(value)
		{
			if (value == 1)
				$scope.dailyRestartEnabled = true;
			else
				$scope.dailyRestartEnabled = false;
		}

		$scope.addServer = function(server)
		{
			if (server.dailyRestart == 1 && ! validateTime(server.restartTime))
			{
				$scope.addStatus = 'warning';
				$scope.addMessage = 'Please enter a valid restart time (hh:mm:ss)!';
			}
			else if(server.dailyRestart == 1 && server.restartCommands == '')
			{
				$scope.addStatus = 'warning';
				$scope.addMessage = 'Please enter at least one restart command!';
			}
			else
			{
				$scope.addStatus = '';
				$scope.adding = true;

				// Send request to add server
				http.post(window.app_path + 'servers/add', JSON.stringify(server)).
				success(function(data)
				{
					$scope.adding = false;

					if(! data.status)
					{
						$scope.addStatus = 'error';
						$scope.addMessage = data.message;
					}
					else
					{
						toasty.pop.success({title: data.message});
						$rootScope.servers.push(data.payload);
						reset();
					}
				}).
				error(function(data, status, headers, config)
				{
					$scope.adding = false;

					$scope.addStatus = 'error';
					$scope.addMessage = errorExceptionMessage(data, status, config);
				});
			}
		}
	}

	/**
	* Reset the dialog
	*/ 
	$scope.reset = function()
	{
		reset();
	};

	/**
	* Close the dialog
	*/ 
	$scope.close = function()
	{
		$modalInstance.dismiss();
	};
});