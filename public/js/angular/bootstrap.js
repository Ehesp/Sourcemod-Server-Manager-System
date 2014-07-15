var app = angular.module('SSMS', ['ui.bootstrap', 'ngCookies', 'ngSanitize','ngAnimate', 'dialogs.main', 'toaster']);

app.controller('MasterCtrl', function($scope, $cookieStore)
{
	var mobileView = 992;

	$scope.getWidth = function() { return window.innerWidth; };

	function setDefaultState()
	{
		if(angular.isDefined($cookieStore.get('toggle')))
			$scope.toggle = $cookieStore.get('toggle');
	}

	setDefaultState();

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