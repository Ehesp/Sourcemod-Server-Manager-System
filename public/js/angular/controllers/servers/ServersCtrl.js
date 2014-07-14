app.controller('ServersCtrl', function($scope, $http, dialogs, http, toaster)
{
	$scope.loading = true;
	$scope.servers = {};

	/**
	* Load SSMS servers
	*/

	function servers()
	{
		http.post(window.app_path + 'servers').
			success(function(data)
			{
				$scope.servers = data;
				$scope.loading = false;
			}).
			error(function(data, status, headers, config)
			{
				$scope.message = errorExceptionMessage(data, status, config);
				$scope.error = true;
				$scope.loading = false;
			});
	}

	servers();

	/**
	* Add server function
	* Load newServerDialogCtrl dialog
	*/ 
   	$scope.addServer = function()
   	{
   		dialogs.create(window.app_path + 'template/servers.new-server', 'newServerDialogCtrl',{});
   	}
})

.controller('newServerDialogCtrl', function($scope, $rootScope, $modalInstance, data, http, toaster)
{
	/**
	* Close the dialog
	*/ 
	$scope.close = function()
	{
		$modalInstance.dismiss();
	};
});