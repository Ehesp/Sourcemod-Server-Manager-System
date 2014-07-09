<!doctype html>
<html lang="en" ng-app="SSMS">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@yield('page_meta_title', 'SSMS')</title>

  @section('assets')
    [[ HTML::style('assets/vendor/bootstrap-css-only/css/bootstrap.min.css') ]]
    [[ HTML::style('assets/vendor/font-awesome/css/font-awesome.min.css') ]]
    [[ HTML::style('assets/vendor/angular-dialog-service/dialogs.min.css') ]]

    [[ HTML::script('assets/vendor/angular/angular.min.js') ]]
    [[ HTML::script('assets/vendor/angular-bootstrap/ui-bootstrap-tpls.min.js') ]]
    [[ HTML::script('assets/vendor/angular-cookies/angular-cookies.min.js') ]]
    [[ HTML::script('assets/vendor/angular-dialog-service/dialogs.min.js') ]]
    [[ HTML::script('assets/vendor/angular-sanitize/angular-sanitize.min.js') ]]
    [[ HTML::script('assets/vendor/angular-translate/angular-translate.min.js') ]]
    
    [[ HTML::style('css/dashboard.min.css') ]]
    [[ HTML::script('js/angular/bootstrap.js') ]]
    [[ HTML::script('js/angular/directives.js') ]]
  @show

</head>
<body ng-controller="MasterCtrl">
  <div id="page-wrapper" ng-class="{'active': toggle}">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
      @include('partials.sidebar')
    </div>
          
    <!-- Page content -->
    <div id="content-wrapper">
      <div class="page-content">

        @include('partials.header')

        @include('partials.flash')

        @yield('content')

      </div>
    </div>
      
  </div>
</body>
</html>
