@extends('master')

@section('page_title')
  Page Management
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]] / [[ HTML::link(URL::route('settings.page-management'), 'Page Management') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/settings/SettingsPageManagementCtrl.js') ]]
@stop

@section('content')
	<div ng-controller="SettingsPageManagementCtrl">
		<div class="row">
			<div class="col-lg-12">
				<div class="widget">
					<div class="widget-title">
						<i class="fa fa-key"></i> Page Management
						<input type="text" class="form-control input-sm pull-right" placeholder="Search..." ng-model="searchPages">
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
										<th>Name</th>
										<th>Icon (<a target="_blank" href="http://fontawesome.io/icons/">Font Awesome</a>)</th>
										<th>Slug</th>
										<th>Role Access</th>
										<th class="text-right"><i class="fa fa-cog"></i></th>
									</tr>
								</thead>
								<tbody>
									 <tr ng-repeat="page in pages | filter:searchPages">
									 	<td ng-bind="page.friendly_name"></td>
									 	<td ng-if="!edit[page.id]"><i class="{{ page.icon }}"></i></td>
									 	<td ng-if="edit[page.id]">
									 		<input type="text" class="form-control input-sm" ng-init="page.edit.icon = page.icon" ng-model="page.edit.icon" /> 
									 	</td>
									 	<td ng-bind="page.slug"></td>
									 	<td ng-if="!edit[page.id]">
											<span class="roles" ng-repeat="role in page.roles" ng-switch="role.name">
												<i ng-switch-when="super_admin" class="fa fa-star" tooltip="Super Admin"></i>
												<i ng-switch-when="admin" class="fa fa-star-half-empty" tooltip="Admin"></i>
												<i ng-switch-when="user" class="fa fa-star-o" tooltip="User"></i>
												<i ng-switch-when="guest" class="fa fa-user" tooltip="Guest"></i>
											</span>
									 	</td>
									 	<td ng-if="edit[page.id]">
									 		<select multiple ng-multiple="true" class="form-control input-sm" ng-init="page.edit.role = selectedRoles[page.id]" ng-model="page.edit.role" ng-options="r.friendly_name for r in roles"></select>
									 	</td>
									 	<td>
											<button ng-if="!edit[page.id]" class="btn btn-warning btn-sm pull-right" ng-click="editPage(page)" tooltip="Edit Page">
												<i class="fa fa-wrench"></i>
											</button>
											<button ng-if="edit[page.id]" class="btn btn-danger btn-sm pull-right" ng-click="editPage(page)" tooltip="Cancel">
												<i class="fa fa-times"></i>
											</button>
											<button ng-if="edit[page.id]" class="btn btn-success btn-sm pull-right" ng-click="savePage(page)" tooltip="Saves Changes">
												<i class="fa" ng-class="{'fa-check': !saving[page.id], 'fa-spinner fa-spin': saving[page.id]}"></i>
											</button>
									 	</td>
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