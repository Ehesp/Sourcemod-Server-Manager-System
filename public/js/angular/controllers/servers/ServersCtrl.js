app.controller('ServersCtrl', function($scope, $http, dialogs, http, toaster)
{
	$scope.loading = true;
	$scope.servers = {};

	/**
	* Load SSMS servers
	*/

	function servers()
	{
		http.post(window.app_path + 'servers').
			success(function(data)
			{
				$scope.servers = data;
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
});