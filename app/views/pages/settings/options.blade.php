@extends('master')

@section('page_title')
  Options
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]] / [[ HTML::link(URL::route('settings.options'), 'Options') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/settings/SettingsOptionsCtrl.js') ]]
@stop

@section('content')
	<div ng-controller="SettingsOptionsCtrl">
		<div class="row">
			<div class="col-lg-12">
				<div class="widget">
					<div class="widget-title">
						<i class="fa fa-cogs"></i> Manage Options
						<input type="text" class="form-control input-sm pull-right" placeholder="Search..." ng-model="searchOptions">
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
										<th>Option</th>
										<th>Description</th>
										<th>Value</th>
										<th>Last Updated</th>
										<th class="text-right"><i class="fa fa-cog"></i></th>
									</tr>
								</thead>
								<tbody>
									 <tr ng-repeat="option in options | filter:searchOptions">
									 	<td ng-bind="option.friendly_name"></td>
									 	<td ng-bind="option.description"></td>
									 	<td ng-if="option.options === null">
									 		<input class="form-control" type="text" ng-model="option.value" />
									 	</td>
									 	<td ng-if="option.options !== null">
									 		<select class="form-control input-sm" ng-model="option.value" ng-options="option for option in stringToArray(option.options, '|')"></select>
									 	</td>
									 	<td ng-bind="option.updated_at"></td>
									 	<td>
									 		<button class="btn btn-success btn-sm pull-right" ng-click="editOption(option)" tooltip="Update">
									 			<i class="fa" ng-class="{'fa-check': !saving[option.id], 'fa-spinner fa-spin': saving[option.id]}"></i>
									 		</button>
									 	</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@stop