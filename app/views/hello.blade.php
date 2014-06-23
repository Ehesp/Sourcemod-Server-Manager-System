<!doctype html>
<html lang="en" ng-app="SSMS">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SSMS</title>

  [[ HTML::style('css/bootstrap.min.css') ]]
  [[ HTML::style('css/font-awesome.min.css') ]]
  [[ HTML::style('css/dashboard.min.css') ]]
  [[ HTML::style('css/content.min.css') ]]

  [[ HTML::script('js/angular.min.js') ]]
  [[ HTML::script('js/ng-bootstrap-tpls.min.js') ]]
  [[ HTML::script('js/angular-cookies.js') ]]

  [[ HTML::script('js/angular/bootstrap.js') ]]



</head>
<body ng-controller="MasterCtrl">
  <div id="page-wrapper" ng-init="toggle" ng-class="{'active': toggle}">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
      <ul class="sidebar">
        <li class="sidebar-main">
          <a href="#" ng-click="toggleSidebar()">
            SSMS 
            <span class="menu-icon glyphicon glyphicon-transfer"></span>
          </a>
        </li>
        <li class="sidebar-title">
          <span>NAVIGATION</span>
        </li>
        <li class="sidebar-list">
          <a href="http://127.0.0.1/git/Sourcemod-Server-Manager-System/public/">Dashboard <span class="menu-icon fa fa-tachometer"></span></a>
        </li>
        <li class="sidebar-list">
          <a href="#">Servers <span class="menu-icon fa fa-tasks"></span></a>
        </li>
        <li class="sidebar-list">
          <a href="#">Settings <span class="menu-icon fa fa-cogs"></span></a>
        </li>
        <li class="sidebar-list">
          <a href="#">Something <span class="menu-icon glyphicon glyphicon-transfer"></span></a>
        </li>
        <li class="sidebar-title"><span>QUICK LINKS</span></li>
        <li class="sidebar-list">
          <a href="#">Forums <span class="menu-icon fa fa-external-link"></span></a>
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
                  <div class="page">
                    Toggle = {{toggle}}
                  </div>
                  <div class="breadcrumb-links">
                    Home / Dashboard {{window_width}}
                  </div>
                </div>
                <div class="user pull-right">
                  <ul>
                    <li> {{old}} = 
              {{new}}</li>
                    <li>B</li>
                    <li>
                      <a href="#">
                        <img src="http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/2b/2b645d34509714b08352da02f13d8db7f0b5c1d5_full.jpg">
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
             
          </div>
        </div>
      </div>
      
    </div>
</body>
</html>
