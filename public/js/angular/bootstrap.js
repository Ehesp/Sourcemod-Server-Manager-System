var app = angular.module('SSMS', ['ui.bootstrap', 'ngCookies']);

app.controller('MasterCtrl', function($scope, $rootScope, $cookieStore)
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
					$rootScope.toggle = false;

				else
					$rootScope.toggle = true;
			}
			else 
			{
				$rootScope.toggle = true;
			}
		}
		else
		{
			$rootScope.toggle = false;
		}

	});

	$scope.toggleSidebar = function() 
	{
		$rootScope.toggle = ! $scope.toggle;

		$cookieStore.put('toggle', $rootScope.toggle);
	};

	window.onresize = function() { $scope.$apply(); };

});