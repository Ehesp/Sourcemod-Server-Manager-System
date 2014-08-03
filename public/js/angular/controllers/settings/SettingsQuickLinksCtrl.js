app.controller('SettingsQuickLinksCtrl', function($scope, $http, dialogs, http, toasty)
{
	$scope.loading = true;
	$scope.links = {};
	$scope.edit = {};
	$scope.saving = {};
	$scope.adding = false;
	$scope.error = false;

	/**
	* Load SSMS quick links
	*/
	http.post(window.app_path + 'settings/quick-links').
		success(function(data)
		{
			$scope.links = data;
			$scope.loading = false;
		}).
		error(function(data, status, headers, config)
		{
			$scope.message = errorExceptionMessage(data, status, config);
			$scope.error = true;
			$scope.loading = false;
		});

	/**
	* Edit quick-link
	*/ 
	$scope.editLink = function(link)
	{
		$scope.edit[link.id] = ! angular.isDefined($scope.edit[link.id]) ? true : ! $scope.edit[link.id];
	}

	/**
	* Save quick-link
	*/ 
	$scope.saveLink = function(link)
	{
		$scope.saving[link.id] = true;

		http.post(window.app_path + 'settings/quick-links/edit', JSON.stringify(link)).
			success(function(data)
			{
				$scope.saving[link.id] = false;

				if(! data.status)
				{
					toasty.pop.error({
						title: 'Failed to save changes!',
						msg: 'Click to more info.',
						showClose: false,
						clickToClose: true,
						timeout: 7000,
						onClick: function(toasty) {
							dialogs.error('An error occured saving the link changes!', errorMessage(data.code, data.message));
						}
					});
				}
				else
				{
					toasty.pop.success({title: data.message, clickToClose: true});
					// Update the user before we close the edit area
					$scope.links[findWithAttr($scope.links, 'id', link.id)] = data.payload;
					$scope.edit[link.id] = false;
				}
			}).
			error(function(data, status, headers, config)
			{
				$scope.saving[link.id] = false;
				dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
			});
	}

	/**
	* Delete quick-link
	*/ 
	$scope.deleteLink = function(link)
	{
		// Trigger dialog
		var d = dialogs.confirm('Delete Quick Link - ' + link.name, 'Are you sure you want to delete this quick link?');

		// On dialog "confirm"
		d.result.then(function(c) {
			http.post(window.app_path + 'settings/quick-links/delete', link.id).
				success(function(data)
				{
					if(! data.status)
					{
						toasty.pop.error({
							title: 'Deleting the quick link failed!',
							msg: 'Click to more info.',
							showClose: false,
							clickToClose: true,
							timeout: 7000,
							onClick: function(toasty) {
								dialogs.error('An error occured while deleting the quick link!', errorMessage(data.code, data.message));
							}
						});
					}
					else
					{
						$scope.links.splice(findWithAttr($scope.links, 'id', link.id), 1);
						toasty.pop.success({title: data.message, clickToClose: true});
					}
				}).
				error(function(data, status, headers, config)
				{
					dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
				});
		});
	}

	/**
	* Add quick-link
	*/ 
	$scope.addLink = function(newlink)
	{
		if (angular.isDefined(newlink))
		{
			if (angular.isDefined(newlink.name) && angular.isDefined(newlink.url) && angular.isDefined(newlink.icon))
			{
				$scope.adding = true;

				http.post(window.app_path + 'settings/quick-links/add', JSON.stringify(newlink)).
					success(function(data)
					{
						$scope.adding = false;

						if(! data.status)
						{
							toasty.pop.error({
								title: 'Adding the quick link failed!',
								msg: 'Click to more info.',
								showClose: false,
								clickToClose: true,
								timeout: 7000,
								onClick: function(toasty) {
									dialogs.error('An error occured while adding the quick link!', errorMessage(data.code, data.message));
								}
							});
						}
						else
						{
							$scope.links.push(data.payload);
							toasty.pop.success({title: data.message, clickToClose: true});
						}
					}).
					error(function(data, status, headers, config)
					{
						$scope.adding = false;
						dialogs.error('A fatal error occured!', errorExceptionMessage(data, status, config));
					});
			}
		}
	}

});