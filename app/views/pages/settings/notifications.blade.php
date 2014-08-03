@extends('master')

@section('page_title')
  Notifications
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]] / [[ HTML::link(URL::route('settings.notifications'), 'Notifications') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/settings/SettingsNotificationsCtrl.js') ]]
@stop

@section('content')
	<div ng-controller="SettingsNotificationsCtrl">
		<div class="row">
			<div class="col-lg-12">
				<div class="widget">
					<div class="widget-title">
						<i class="fa fa-flag"></i> Manage Notifications
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
									 <tr ng-repeat="notification in notifications">
									 	<td ng-bind="notification.friendly_name"></td>
									 	<td ng-bind="notification.description"></td>
									 	<td ng-if="notification.options === null">
									 		<input class="form-control" type="text" ng-model="notification.value" />
									 	</td>
									 	<td ng-if="notification.options !== null">
									 		<select class="form-control input-sm" ng-model="notification.value" ng-options="notification for notification in stringToArray(notification.options, '|')"></select>
									 	</td>
									 	<td ng-bind="notification.updated_at"></td>
									 	<td>
									 		<button class="btn btn-success btn-sm pull-right" ng-click="editNotification(notification)" tooltip="Update">
									 			<i class="fa" ng-class="{'fa-check': !saving[notification.id], 'fa-spinner fa-spin': saving[notification.id]}"></i>
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
		<div class="row">
			<div class="col-lg-12">
				<div class="widget">
					<div class="widget-title">
						<i class="fa fa-bullhorn"></i> Event Management
					</div>
					<div class="widget-body no-padding">

						<loading ng-if="loadingEvents"></loading>

						<div class="error" ng-if="!loadingEvents && errorEvents">
							<span ng-bind-html="message"></span>
						</div>

						<table class="table" ng-if="!loadingEvents && !errorEvents">
							<thead>
								<tr>
									<th>Name</th>
									<th>Description</th>
									<th>Services</th>
									<th class="text-right"><i class="fa fa-cog"></i></th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="event in events">
									<td ng-bind="event.name"></td>
									<td ng-bind="event.description"></td>
									<td ng-if="!edit[event.id]">
										<span ng-repeat="service in event.services">
											{{ service.friendly_name }} <span ng-if="!$last">|</span>
										</span>
								 	</td>
								 	<td ng-if="edit[event.id]">
								 		<select multiple ng-multiple="true" class="form-control input-sm" ng-init="event.edit.service = selectedServices[event.id]" ng-model="event.edit.service" ng-options="s.friendly_name for s in services"></select>
								 	</td>
								 	<td>
										<button ng-if="!edit[event.id]" class="btn btn-warning btn-sm pull-right" ng-click="editEvent(event)" tooltip="Edit Event">
											<i class="fa fa-wrench"></i>
										</button>
										<button ng-if="edit[event.id]" class="btn btn-danger btn-sm pull-right" ng-click="editEvent(event)" tooltip="Cancel">
											<i class="fa fa-times"></i>
										</button>
										<button ng-if="edit[event.id]" class="btn btn-success btn-sm pull-right" ng-click="saveEvent(event)" tooltip="Saves Changes">
											<i class="fa" ng-class="{'fa-check': !savingEvent[event.id], 'fa-spinner fa-spin': savingEvent[event.id]}"></i>
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
	@stop