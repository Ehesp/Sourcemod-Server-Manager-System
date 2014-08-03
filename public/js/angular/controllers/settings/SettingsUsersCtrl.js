app.controller('SettingsUsersCtrl', function($scope, $rootScope, dialogs, http, toasty)
{
	/**
	* Scope Variables
	*/ 
	$scope.loading = true;
	$scope.saving = {};
	$scope.refreshing = {};
	$scope.mass = false;
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
	// Remove the guest from the variable, as we are not going to 
	// set a user manually as a guest
	delete $rootScope.roles[findWithAttr($rootScope.roles, 'friendly_name', 'Guest')];

	/**
	* Load SSMS users
	*/
	http.post(window.app_path + 'settings/users').
		success(function(data)
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
						toasty.pop.error({
							title: 'Deleting the user failed!',
							msg: 'Click to more info.',
							showClose: false,
							clickToClose: true,
							timeout: 7000,
							onClick: function(toasty) {
								dialogs.error('An error occured while deleting the user!', errorMessage(data.code, data.message));
							}
						});
					}
					else
					{
						$rootScope.users.splice(findWithAttr($rootScope.users, 'id', user.id), 1);
						toasty.pop.success({title: data.message, clickToClose: true});
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
   		dialogs.create(window.app_path + 'templates/secure/settings.users.add', 'newUserDialogCtrl',{});
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
		$scope.saving[user.id] = true;

		http.post(window.app_path + 'settings/users/edit', JSON.stringify(user)).
			success(function(data)
			{
				$scope.saving[user.id] = false;

				if(! data.status)
				{
					toasty.pop.error({
						title: 'Failed to save changes!',
						msg: 'Click to more info.',
						showClose: false,
						clickToClose: true,
						timeout: 7000,
						onClick: function(toasty) {
							dialogs.error('An error occured saving the user changes!', errorMessage(data.code, data.message));
						}
					});
				}
				else
				{
					toasty.pop.success({title: data.message, clickToClose: true});
					// Update the user before we close the edit area
					$rootScope.users[findWithAttr($rootScope.users, 'id', user.id)] = data.payload;
					$scope.edit[user.id] = false;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.saving[user.id] = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});
	}

	/**
	* Refresh a single user
	*/ 
	$scope.refreshUser = function(user)
	{
		$scope.refreshing[user.id] = true;

		http.post(window.app_path + 'settings/users/refresh/'+ user.id, JSON.stringify(user)).
			success(function(data)
			{
				if(! data.status)
				{
					toasty.pop.error({
						title: 'Failed to refresh user!',
						msg: 'Click to more info.',
						showClose: false,
						clickToClose: true,
						timeout: 7000,
						onClick: function(toasty) {
							dialogs.error('An error occured while refreshing the users details!', errorMessage(data.code, data.message));
						}
					});
				}
				else
				{
					toasty.pop.success({title: data.message, clickToClose: true});
					$rootScope.users[findWithAttr($rootScope.users, 'id', user.id)] = data.payload;
					$scope.refreshing[user.id] = false;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.refreshing[user.id] = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});
	}

	/**
	* Refresh all users
	*/ 
	$scope.massRefresh = function()
	{
		$scope.mass = true;

		http.post(window.app_path + 'settings/users/refresh').
			success(function(data)
			{
				$scope.mass = false;

				if(! data.status)
				{
					toasty.pop.error({
						title: 'An error occured while refreshing the users!',
						msg: 'Click to more info.',
						showClose: false,
						clickToClose: true,
						timeout: 7000,
						onClick: function(toasty) {
							dialogs.error('An error occured while refreshing the application users!', errorMessage(data.code, data.message));
						}
					});
				}
				else
				{
					toasty.pop.success({title: data.message, clickToClose: true});
					$rootScope.users = data.payload;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.mass = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});
	}
})

/**
* New user dialog controller
*/ 

.controller('newUserDialogCtrl', function($scope, $rootScope, $modalInstance, data, http, toasty)
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
					toasty.pop.success({title: 'User added!', clickToClose: true});
					$rootScope.users.push(data.payload);
					reset();
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