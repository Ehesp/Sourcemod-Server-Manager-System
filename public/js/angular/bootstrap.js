var app = angular.module('SSMS', ['ui.bootstrap', 'ngCookies', 'ngSanitize','ngAnimate', 'dialogs.main', 'toaster']);

app.controller('MasterCtrl', function($scope, $cookieStore)
{
	var mobileView = 992;

	$scope.getWidth = function() { return window.innerWidth; };

	$scope.$watch($scope.getWidth, function(newValue, oldValue)
	{
		if(newValue >= mobileView)
		{
			if(angular.isDefined($cookieStore.get('toggle')))
			{
				if($cookieStore.get('toggle') == false)
					$scope.toggle = false;

				else
					$scope.toggle = true;
			}
			else 
			{
				$scope.toggle = true;
			}
		}
		else
		{
			$scope.toggle = false;
		}

	});

	$scope.toggleSidebar = function() 
	{
		$scope.toggle = ! $scope.toggle;

		$cookieStore.put('toggle', $scope.toggle);
	};

	window.onresize = function() { $scope.$apply(); };


});

function errorMessage(data, status, config)
{
	message = "<u class='message-heading'>An error occured!</u><br />";
	message += "Error: " + data.error.message + "<br />";
	message += "Exception: " + data.error.type + "<br />";
	message += config.method + " " + config.url + ", HTTP status " + status;

	return message;
}