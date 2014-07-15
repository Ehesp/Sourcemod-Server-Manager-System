app.controller('ServersCtrl', function($scope, $rootScope, dialogs, http, toaster)
{
	$scope.loading = true;
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
   		dialogs.create(window.app_path + 'template/servers.new-server', 'newServerDialogCtrl',{});
   	}
})

.controller('newServerDialogCtrl', function($scope, $rootScope, $modalInstance, data, http, toaster)
{
	function reset()
	{
		$scope.server = {};

		$scope.success = false;
		$scope.successRcon = false;

		$scope.warning = {};
		$scope.error = false;
		$scope.errorRcon = false;

		$scope.message = false;
		$scope.messageRcon = false;

		$scope.warning.main = false;
		$scope.warning.ip = false;
		$scope.warning.port = false;

		$scope.searching = false;
		$scope.found = false;

		$scope.adding = false;
		$scope.addUserError = false;

		$scope.validating = false;
	}

	reset();

	$scope.search = function(server)
	{
		if (! angular.isDefined(server.ip) || ! validateIp(server.ip))
		{
			$scope.success = false;
			$scope.warning.main = true;

			$scope.warning.ip = true;
			$scope.error = false;

			$scope.searching = false;

			$scope.message = 'Please enter a valid IP address!';
		}
		else if(! angular.isDefined(server.port) ||! validateNumber(server.port))
		{
			$scope.success = false;
			$scope.warning.main = true;

			$scope.warning.ip = false;
			$scope.warning.port = true;
			$scope.error = false;

			$scope.searching = false;

			$scope.message = 'Please enter a valid port number!';
		}
		else
		{
			$scope.success = false;
			$scope.warning.main = false;
			$scope.error = false;

			$scope.warning.ip = false;
			$scope.warning.port = false;

			$scope.searching = true;

			$scope.message = false;

			// Send request to search for server
			http.post(window.app_path + 'servers/add/search', JSON.stringify(server)).
				success(function(data)
				{
					$scope.searching = false;

					if(! data.status)
					{
						$scope.error = true;
						$scope.message = data.message;
					}
					else
					{
						$scope.success = true;
						$scope.message = data.message;

						$scope.found = true;
						$scope.newServer = data.payload;
					}
				}).
				error(function(data, status, headers, config)
				{
					$scope.searching = false;

					$scope.error = true;
					$scope.message = errorExceptionMessage(data, status, config);
				});
		}
	}

	$scope.validate = function(server)
	{
		$scope.validating = true;

		// Send request to search for server
		http.post(window.app_path + 'servers/add/validate', JSON.stringify(server)).
			success(function(data)
			{
				$scope.validating = false;

				if(! data.status)
				{
					$scope.errorRcon = true;
					$scope.successRcon = true;
					$scope.messageRcon = data.message;
				}
				else
				{
					$scope.successRcon = false;
					$scope.messageRcon = data.message;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.validating = false;

				$scope.errorRcon = true;
				$scope.messageRcon = errorExceptionMessage(data, status, config);
			});
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