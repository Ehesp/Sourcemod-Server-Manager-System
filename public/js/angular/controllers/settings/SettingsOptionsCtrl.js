app.controller('SettingsOptionsCtrl', function($scope, $http, dialogs, http, toasty)
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
				toasty.pop.error({
					title: 'An error occured saving the option!',
					msg: 'Click to more info.',
					timeout: 7000,
					onClick: function(toasty) {
						dialogs.error('An error occured while saving the option!', errorMessage(data.code, data.message));
					}
				});		
			}
			else
			{
				$scope.options[findWithAttr($scope.options, 'id', option.id)] = data.payload;
				toasty.pop.success({title: data.message});
			}
		}).
		error(function(data, status, headers, config)
		{
			$scope.saving[option.id] = false;
			dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
		});
	}
});