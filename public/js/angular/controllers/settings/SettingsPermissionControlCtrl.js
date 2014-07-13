app.controller('SettingsPermissionControlCtrl', function($scope, $http, dialogs, http, toaster)
{
	$scope.loading = true;
	$scope.permissions = {};
	$scope.saving = {};
	$scope.edit = {};
	$scope.saving = {};
	$scope.selectedRoles = {};

	$scope.roles = window.roles;

	/**
	* Load SSMS permissions
	*/
	http.post(window.app_path + 'settings/permission-control').
		success(function(data)
		{
			$scope.permissions = data;
			$scope.loading = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.error = true;
			$scope.loading = false;
		});

	/**
	* Edit permission
	*/ 
	$scope.editPermission = function(permission)
	{
		$scope.edit[permission.id] = ! angular.isDefined($scope.edit[permission.id]) ? true : ! $scope.edit[permission.id];

		// Assign a variable the roles the permission has so we're able to default them
		$scope.selectedRoles[permission.id] = [];
		angular.forEach(permission.roles, function(value, key)
		{
			if (angular.isDefined($scope.roles[findWithAttr($scope.roles, 'id', value.id)]))
			{
				$scope.selectedRoles[permission.id].push($scope.roles[findWithAttr($scope.roles, 'id', value.id)]);
			}
		});
	}

	/**
	* Save permission settings
	*/ 
	$scope.savePermission = function(permission)
	{
		$scope.saving[permission.id] = true;

		http.post(window.app_path + 'settings/permission-control/edit', JSON.stringify(permission)).
			success(function(data)
			{
				$scope.saving[permission.id] = false;

				if(! data.status)
				{
					toaster.pop('error', 'Failed to save changes!', '', null, null, function()
					{
						dialogs.error('An error occured saving the permission changes!', errorMessage(data.code, data.message));
					});
				}
				else
				{
					toaster.pop('success', data.message);

					// Update the permission before we close the edit area
					$scope.permissions[findWithAttr($scope.permissions, 'id', permission.id)] = data.payload;

					$scope.edit[permission.id] = false;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.saving = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});
	}

});