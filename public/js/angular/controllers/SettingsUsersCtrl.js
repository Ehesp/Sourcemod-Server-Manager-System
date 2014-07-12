app.controller('SettingsUsersCtrl', function($scope, $rootScope, $http, dialogs, http, toaster)
{
	/**
	* Scope Variables
	*/ 
	$scope.loading = true;
	$scope.saving = false;
	$scope.error = false;
	$scope.message = '';
	$scope.edit = {};
	$scope.selectedRoles = {};

	// Pass data into the rootScope as we need to access
	// them in the dialog(s) within another scope
	$rootScope.users = [];
	// Set user states: enabled/disabled
	$rootScope.states = [{ value: 0, name: 'disabled'},{ value: 1, name: 'enabled'}];
	// Get the none guest roles from the window
	$rootScope.roles = window.roles;

	/**
	* Load SSMS users
	*/ 
	http.post(window.app_path + 'settings/users').
		success(function(data, status, headers, config)
		{
			$rootScope.users = data;
			$scope.loading = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.error = true;
			$scope.loading = false;
		});

	/**
	* Delete user function
	*/ 
	$scope.deleteUser = function(user)
	{
		// Trigger dialog
		var d = dialogs.confirm('Delete User - ' + user.community_id, 'Are you sure you want to delete the user "'+ user.nickname + '"?');

		// On dialog "confirm"
		d.result.then(function(c) {
			http.post(window.app_path + 'settings/users/delete', user.id).
				success(function(data)
				{
					if(! data.status)
					{
						toaster.pop('error', 'Deleting the user failed!', '', null, null, function()
						{
							dialogs.error('An error occured while deleting the user', errorMessage(data.code, data.message));
						});
					}
					else
					{
						$rootScope.users.splice(findWithAttr($rootScope.users, 'id', user.id), 1);
						toaster.pop('success', data.message);	
					}
				}).
				error(function(data, status, headers, config)
				{
					dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
				});
		});
	};

	/**
	* Add user function
	* Load newUserDialogCtrl dialog
	*/ 
   	$scope.addUser = function()
   	{
   		var d = dialogs.create(window.template_path + 'dialogs/settings.new-user.html', 'newUserDialogCtrl',{});
   	}

	/**
	* Edit user function
	*/ 
	$scope.editUser = function(user)
	{
		$scope.edit[user.id] = ! angular.isDefined($scope.edit[user.id]) ? true : ! $scope.edit[user.id];

		// Assign a variable the roles the user has so we're able to default them
		$scope.selectedRoles[user.id] = [];
		angular.forEach(user.roles, function(value, key)
		{
			if (angular.isDefined($rootScope.roles[findWithAttr($rootScope.roles, 'id', value.id)]))
			{
				$scope.selectedRoles[user.id].push($rootScope.roles[findWithAttr($rootScope.roles, 'id', value.id)]);
			}
		});
	}

	/**
	* Save the edit
	*/ 
	$scope.saveEdit = function(user)
	{
		$scope.saving = true;

		http.post(window.app_path + 'settings/users/edit', JSON.stringify(user)).
			success(function(data)
			{
				console.log(data.payload);
				console.log($rootScope.users[0]);

				$scope.saving = false;

				if(! data.status)
				{
					toaster.pop('error', 'Failed to save changes!', '', null, null, function()
					{
						dialogs.error('An error occured saving the user changes!', errorMessage(data.code, data.message));
					});
				}
				else
				{
					toaster.pop('success', data.message);

					// Update the user before we close the edit area
					$rootScope.users[findWithAttr($rootScope.users, 'id', user.id)] = data.payload;

					$scope.edit[user.id] = false;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.saving = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});

		
	}
})

/**
* New user dialog controller
*/ 

.controller('newUserDialogCtrl', function($scope, $rootScope, $modalInstance, data, http, toaster)
{
	// Scope defaults / reset defaults
	function reset()
	{
		$scope.steam = {};
		$scope.user = {};

		$scope.success = false;
		$scope.warning = false;
		$scope.error = false;

		$scope.searching = false;
		$scope.found = false;
		$scope.message = false;

		$scope.adding = false;
		$scope.addUserError = false;
	}

	reset();

	/**
	* Search Steam User
	*/ 
	$scope.search = function(steam)
	{
		// If Steam ID is not valid
		if (! validateSteamData(steam.id))
		{
			$scope.success = false;
			$scope.error = false;
			$scope.warning = true;
			$scope.searching = false;

			$scope.message = 'Please enter a valid Steam or Community ID!';
		}
		else
		{
			$scope.success = false;
			$scope.warning = false;
			$scope.error = false;
			$scope.searching = true;

			$scope.message = '';

			// Send request to search for user
			http.post(window.app_path + 'settings/users/add/search', JSON.stringify(steam.id)).
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
						$scope.user = data.payload;
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

	/**
	* Add user to SSMS
	*/ 
	$scope.addUser = function(user)
	{
		$scope.adding = true;

		http.post(window.app_path + 'settings/users/add', JSON.stringify(user)).
			success(function(data)
			{
				$scope.adding = false;

				if(! data.status)
				{
					console.log(data);
					$scope.addUserError = data.message;
				}
				else
				{
					toaster.pop('success', 'User added!');
					reset();
					$rootScope.users.push(data.payload);
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.adding = false;

				$scope.addUserError = errorExceptionMessage(data, status, config);
			});
	}

	/**
	* Reset the dialog
	*/ 
	$scope.reset = function()
	{
		reset();
	}

	/**
	* Close the dialog
	*/ 
	$scope.close = function()
	{
		$modalInstance.dismiss();
	};
});