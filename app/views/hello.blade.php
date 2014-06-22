<!doctype html>
<html lang="en" ng-app>
<head>
	<meta charset="UTF-8">
	<title>SSMS</title>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>

	[[ HTML::style('css/dashboard.min.css') ]]

</head>
<body>
  <div id="page-wrapper" ng-class="{'active': toggle}">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
      <ul class="sidebar">
        <li class="sidebar-main">
          <a href="#" ng-init="toggle = true" ng-click="toggle = !toggle">
            SSMS
            <span class="menu-icon glyphicon glyphicon-transfer"></span>
          </a>
        </li>
        <li class="sidebar-title">
          <span>NAVIGATION</span>
        </li>
        <li class="sidebar-list">
          <a href="#">Dashboard <span class="menu-icon glyphicon glyphicon-dashboard"></span></a>
        </li>
        <li class="sidebar-list">
          <a href="#">Servers <span class="menu-icon glyphicon glyphicon-transfer"></span></a>
        </li>
        <li class="sidebar-list">
          <a href="#">Settings <span class="menu-icon glyphicon glyphicon-transfer"></span></a>
        </li>
        <li class="sidebar-list">
          <a href="#">Something <span class="menu-icon glyphicon glyphicon-transfer"></span></a>
        </li>
        <li class="sidebar-title"><span>QUICK LINKS</span></li>
        <li class="sidebar-list">
          <a href="#">Forums <span class="menu-icon glyphicon glyphicon-dashboard"></span></a>
        </li>
      </ul>
    </div>
          
      <!-- Page content -->
      <div id="content-wrapper">
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content">
          <div class="row">
              <div class="header col-xs-12">
                <div class="meta pull-left">
                  Page
                </div>
                <div class="user pull-right">
                  User profile
                </div>
              </div>
          </div>
        </div>
      </div>
      
    </div>
</body>
</html>
