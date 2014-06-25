<!doctype html>
<html lang="en" ng-app="SSMS">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@yield('page_meta_title', 'SSMS')</title>

  @section('scripts')
    [[ HTML::style('css/bootstrap.min.css') ]]
    [[ HTML::style('css/font-awesome.min.css') ]]
    [[ HTML::style('css/dashboard.min.css') ]]

    [[ HTML::script('js/angular.min.js') ]]
    [[ HTML::script('js/ng-bootstrap-tpls.min.js') ]]
    [[ HTML::script('js/angular-cookies.js') ]]

    [[ HTML::script('js/angular/bootstrap.js') ]]
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
