app.controller('SettingsOptionsCtrl', function($scope, $http, dialogs, http, toaster)
{
	$scope.loading = true;
	$scope.error = false;
	$scope.options = {};
	$scope.saving = {};

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
	$scope.editOption = function(option)
	{
		$scope.saving[option.id] = true;

		http.post(window.app_path + 'settings/options/edit', JSON.stringify(option)).
		success(function(data)
		{
			$scope.saving[option.id] = false;
			if (! data.status)
			{
				toaster.pop('error', 'An error occured saving the option!', '', null, null, function()
				{
					dialogs.error('An error occured while saving the option!', errorMessage(data.code, data.message));
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
			$scope.saving[option.id] = false;
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