app.controller('SettingsOptionsCtrl', function($scope, $http, dialogs, http, toaster)
{
	$scope.loading = true;
	$scope.options = {};
	$scope.updating = {};

	/**
	* Load SSMS options
	*/
	http.post(window.app_path + 'settings/options').
		success(function(data)
		{
			$scope.options = data;
			$scope.loading = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.error = true;
			$scope.loading = false;
		});

	/**
	* Update an option
	*/
	$scope.updateOption = function(option)
	{
		$scope.updating[option.id] = true;

		http.post(window.app_path + 'settings/options/update', JSON.stringify(option)).
		success(function(data)
		{
			$scope.updating[option.id] = false;
			if (! data.status)
			{
				toaster.pop('error', 'An error occured updating the option!', '', null, null, function()
				{
					dialogs.error('An error occured while updating the option!', errorMessage(data.code, data.message));
				});				
			}
			else
			{
				toaster.pop('success', data.message);
				$scope.options[findWithAttr($scope.options, 'id', option.id)] = data.payload;
			}
		}).
		error(function(data, status, headers, config)
		{
			$scope.updating[option.id] = false;
			dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
		});
	}

	/**
	* Convert a string into an array (for use in loops)
	*/
	$scope.stringToArray = function(string, sep)
	{
		return string.split(sep);
	}
});