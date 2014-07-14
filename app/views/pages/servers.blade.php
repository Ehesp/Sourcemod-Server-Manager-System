@extends('master')

@section('page_title')
  Servers
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('servers'), 'Servers') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/servers/ServersCtrl.js') ]]
@stop

@section('content')
<div ng-controller="ServersCtrl">
	<div class="row">
		<div class="col-lg-12">
			<div class="widget">
				<div class="widget-title">
					<i class="fa fa-tasks"></i> Servers
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." ng-model="searchServers">
					<div class="clearfix"></div>
				</div>
				<div class="widget-body no-padding">

					<loading ng-if="loading"></loading>

					<div class="error" ng-if="!loading && error">
						<span ng-bind-html="message"></span>
					</div>

					<div class="table-responsive" ng-if="!loading && !error">
						<table class="table">
							<thead>
								<tr>
									<th></th>
									<th>ID</th>
									<th></th>
									<th>Name</th>
									<th>Current Map</th>
									<th>Players</th>
									<th>Last Updated</th>
									<th class="text-right"><i class="fa fa-cog"></i></th>
								</tr>
							</thead>
							<tbody>
								 <tr ng-repeat="server in servers | filter:searchServers">

								 </tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	@include('partials.toaster')

	</div>
</div>
@stop