app.controller('SettingsPageManagementCtrl', function($scope, $http, dialogs, http, toasty)
{
	$scope.loading = true;
	$scope.error = false;
	$scope.pages = {};
	$scope.edit = {};
	$scope.saving = {};
	$scope.selectedRoles = {};

	$scope.roles = window.roles;

	/**
	* Load SSMS options
	*/
	http.post(window.app_path + 'settings/page-management').
		success(function(data)
		{
			$scope.pages = data;
			$scope.loading = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.error = true;
			$scope.loading = false;
		});

	/**
	* Edit page settings
	*/ 
	$scope.editPage = function(page)
	{
		$scope.edit[page.id] = ! angular.isDefined($scope.edit[page.id]) ? true : ! $scope.edit[page.id];

		// Assign a variable the roles the page has so we're able to default them
		$scope.selectedRoles[page.id] = [];
		angular.forEach(page.roles, function(value, key)
		{
			if (angular.isDefined($scope.roles[findWithAttr($scope.roles, 'id', value.id)]))
			{
				$scope.selectedRoles[page.id].push($scope.roles[findWithAttr($scope.roles, 'id', value.id)]);
			}
		});
	}

	/**
	* Save page settings
	*/ 
	$scope.savePage = function(page)
	{
		$scope.saving[page.id] = true;

		http.post(window.app_path + 'settings/page-management/edit', JSON.stringify(page)).
			success(function(data)
			{
				$scope.saving[page.id] = false;

				if(! data.status)
				{
					toasty.pop.error({
						title: 'Failed to save changes!',
						msg: 'Click to more info.',
						timeout: 7000,
						onClick: function(toasty) {
							dialogs.error('An error occured saving the page changes!', errorMessage(data.code, data.message));
						}
					});
				}
				else
				{
					toasty.pop.success({title: data.message});
					// Update the user before we close the edit area
					$scope.pages[findWithAttr($scope.pages, 'id', page.id)] = data.payload;
					$scope.edit[page.id] = false;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.saving[page.id] = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});
	}
});