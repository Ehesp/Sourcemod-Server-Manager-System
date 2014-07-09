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
		error(status);
	});

	function error(status)
	{
		$scope.error = true;
		$scope.message = 'An error occurred and the data could not be loaded! HTTP Status ' + status;
		$scope.loading = false;
	}

});