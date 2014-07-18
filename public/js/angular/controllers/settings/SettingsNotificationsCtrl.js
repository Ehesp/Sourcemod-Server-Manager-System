app.controller('SettingsNotificationsCtrl', function($scope, $http, dialogs, http, toaster)
{
	$scope.loading = true;
	$scope.error = false;

	$scope.loading.events = true;
	$scope.error.events = true;
	
	$scope.notifications = {};
	$scope.events = {};

	$scope.saving = {};
	$scope.saving.events = {};

	/**
	* Load SSMS notifications
	*/
	http.post(window.app_path + 'settings/notifications').
		success(function(data)
		{
			$scope.notifications = data;
			$scope.loading = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.error = true;
			$scope.loading = false;
		});

	/**
	* Load SSMS event settings
	*/
	http.post(window.app_path + 'settings/notifications/events').
		success(function(data)
		{
			$scope.events = data;
			$scope.loading.events = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.loading.events = false;
			$scope.error.events = true;
		});

	/**
	* Update a notification
	*/
	$scope.editNotification = function(notification)
	{
		$scope.saving[notification.id] = true;

		http.post(window.app_path + 'settings/notifications/edit', JSON.stringify(notification)).
		success(function(data)
		{
			$scope.saving[notification.id] = false;
			if (! data.status)
			{
				toaster.pop('error', 'An error occured saving the notification!', '', null, null, function()
				{
					dialogs.error('An error occured while saving the notification!', errorMessage(data.code, data.message));
				});				
			}
			else
			{
				toaster.pop('success', data.message);
				$scope.notifications[findWithAttr($scope.notifications, 'id', notification.id)] = data.payload;
			}
		}).
		error(function(data, status, headers, config)
		{
			$scope.saving[notification.id] = false;
			dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
		});
	}

});