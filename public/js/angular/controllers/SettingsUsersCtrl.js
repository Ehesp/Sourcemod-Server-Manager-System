app.controller('SettingsUsersCtrl', function($scope, $http)
{
	$scope.loading = true;
	$scope.error = false;
	$scope.message = '';
	$scope.users = {};

	$http({method: 'POST', url: window.app_path + 'settings/users'}).
	success(function(data, status, headers, config)
	{
		if (status != 200)
		{
			error(status);
		}
		else
		{
			$scope.users = data;
			$scope.loading = false;
		}
	}).
	error(function(data, status, headers, config)
	{
		error(data, status, config);
	});

	function error(data, status, config)
	{
		message = "An error occurred and the data could not be loaded!<br />";
		message += "Error: " + data.error.message + "<br />";
		message += "Exception: " + data.error.type + "<br />";
		message += config.method + " " + config.url + ", HTTP status " + status;

		$scope.message = message;
		$scope.error = true;
		$scope.loading = false;
	}

});