<!doctype html>
<html lang="en" ng-app="SSMS">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@yield('page_meta_title', $siteOptions['application_title'])</title>

  @section('assets')
    [[-- CSS Vendor --]]
    [[ HTML::style('assets/vendor/bootstrap-css-only/css/bootstrap.min.css') ]]
    [[ HTML::style('assets/vendor/font-awesome/css/font-awesome.min.css') ]]
    [[ HTML::style('assets/vendor/angular-dialog-service/dialogs.min.css') ]]
    [[ HTML::style('assets/vendor/angular-toasty/css/ng-toasty.css') ]]

    [[-- JS Vendor --]]
    [[ HTML::script('assets/vendor/angular/angular.min.js') ]]
    [[ HTML::script('assets/vendor/angular-bootstrap/ui-bootstrap-tpls.min.js') ]]
    [[ HTML::script('assets/vendor/angular-cookies/angular-cookies.min.js') ]]
    [[ HTML::script('assets/vendor/angular-sanitize/angular-sanitize.min.js') ]]
    [[ HTML::script('assets/vendor/angular-translate/angular-translate.min.js') ]]
    [[ HTML::script('assets/vendor/angular-animate/angular-animate.min.js') ]]
    [[ HTML::script('assets/vendor/angular-dialog-service/dialogs.min.js') ]]
    [[ HTML::script('assets/vendor/angular-toasty/js/ng-toasty.min.js') ]]
    
    [[-- Custom CSS --]]
    [[ HTML::style('css/dashboard.min.css') ]]
    [[ HTML::style('css/themes/' . $siteOptions['theme'] . '.min.css') ]]

    [[-- Custom JS --]]
    [[ HTML::script('js/helpers.js') ]]
    [[ HTML::script('js/angular/bootstrap.js') ]]
    [[ HTML::script('js/angular/directives.js') ]]
    [[ HTML::script('js/angular/services.js') ]]
  @show

</head>
<body ng-controller="MasterCtrl">
  <div id="page-wrapper" ng-class="{'active': toggle}" ng-cloak>

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
  @include('partials.toasty')
</body>
</html>
