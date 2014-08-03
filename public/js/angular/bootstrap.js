var app = angular.module('SSMS', ['ui.bootstrap', 'ngCookies', 'ngSanitize','ngAnimate', 'dialogs.main', 'toasty']);

app.controller('MasterCtrl', function($scope, $cookieStore)
{
	/**
	 * Sidebar Toggle & Cookie Control
	 *
	 */
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

	/**
	 * In-Scope helpers
	 *
	 */
	$scope.stringToArray = function(string, sep)
	{
		return string.split(sep);
	}

});