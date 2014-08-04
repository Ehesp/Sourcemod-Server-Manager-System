app.controller('SettingsNotificationsCtrl', function($scope, $http, dialogs, http, toasty)
{
	$scope.loading = true;
	$scope.error = false;

	$scope.loadingEvents = true;
	$scope.errorEvents = false;
	
	$scope.notifications = {};
	$scope.events = {};

	$scope.edit = {};
	$scope.selectedServices = {};
	$scope.saving = {};
	$scope.savingEvent = {};

	$scope.services = window.services;

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
			$scope.loadingEvents = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.messageEvents = errorExceptionMessage(data, status, config);
			$scope.loadingEvents = false;
			$scope.errorEvents = true;
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
				toasty.pop.error({
					title: 'An error occured saving the notification!',
					msg: 'Click to more info.',
					timeout: 7000,
					onClick: function(toasty) {
						dialogs.error('An error occured while saving the notification!', errorMessage(data.code, data.message));
					}
				});		
			}
			else
			{
				toasty.pop.success({title: data.message});
				$scope.notifications[findWithAttr($scope.notifications, 'id', notification.id)] = data.payload;
			}
		}).
		error(function(data, status, headers, config)
		{
			$scope.saving[notification.id] = false;
			dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
		});
	}

	/**
	* Edit event settings
	*/ 
	$scope.editEvent = function(event)
	{
		$scope.edit[event.id] = ! angular.isDefined($scope.edit[event.id]) ? true : ! $scope.edit[event.id];

		$scope.selectedServices[event.id] = [];
		angular.forEach(event.services, function(value, key)
		{
			if (angular.isDefined($scope.services[findWithAttr($scope.services, 'id', value.id)]))
			{
				$scope.selectedServices[event.id].push($scope.services[findWithAttr($scope.services, 'id', value.id)]);
			}
		});
	}

	/**
	* Save event settings
	*/ 
	$scope.saveEvent = function(event)
	{
		$scope.savingEvent[event.id] = true;

		http.post(window.app_path + 'settings/notifications/event/edit', JSON.stringify(event)).
			success(function(data)
			{
				$scope.savingEvent[event.id] = false;

				if(! data.status)
				{
					toasty.pop.error({
						title: 'Failed to save changes!',
						msg: 'Click to more info.',
						timeout: 7000,
						onClick: function(toasty) {
							dialogs.error('An error occured saving the event changes!', errorMessage(data.code, data.message));
						}
					});
				}
				else
				{
					toasty.pop.success({title: data.message});
					// Update the event before we close the edit area
					$scope.events[findWithAttr($scope.events, 'id', event.id)] = data.payload;
					$scope.edit[event.id] = false;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.savingEvent[event.id] = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});
	}

});