@extends('master')

@section('page_title')
  Permission Control
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]] / [[ HTML::link(URL::route('settings.permission-control'), 'Permission Control') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/settings/SettingsPermissionControlCtrl.js') ]]
@stop

@section('content')
	<div ng-controller="SettingsPermissionControlCtrl">
		<div class="row">
			<div class="col-lg-12">
				<div class="widget">
					<div class="widget-title">
						<i class="fa fa-unlock-alt"></i> Manage Permissions
						<input type="text" class="form-control input-sm pull-right" placeholder="Search..." ng-model="searchPermissions">
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
										<th>Description</th>
										<th>Page</th>
										<th>Roles</th>
										<th class="text-right"><i class="fa fa-cog"></i></th>
									</tr>
								</thead>
								<tbody>
									 <tr ng-repeat="permission in permissions | filter:searchPermissions">
									 	<td ng-bind="permission.name"></td>
									 	<td ng-bind="permission.description"></td>
									 	<td ng-bind="permission.page.friendly_name"></td>
									 	<td ng-if="!edit[permission.id]">
									 		<span class="roles" ng-repeat="role in permission.roles" ng-switch="role.name">
												<i ng-switch-when="super_admin" class="fa fa-star" tooltip="Super Admin"></i>
												<i ng-switch-when="admin" class="fa fa-star-half-empty" tooltip="Admin"></i>
												<i ng-switch-when="user" class="fa fa-star-o" tooltip="User"></i>
												<i ng-switch-when="guest" class="fa fa-user" tooltip="Guest"></i>
											</span>
									 	</td>
									 	<td ng-if="edit[permission.id]">
									 		<select multiple ng-multiple="true" class="form-control input-sm" ng-init="permission.edit.role = selectedRoles[permission.id]" ng-model="permission.edit.role" ng-options="r.friendly_name for r in roles"></select>
									 	</td>
									 	<td>
											<button ng-if="!edit[permission.id]" class="btn btn-warning btn-sm pull-right" ng-click="editPermission(permission)" tooltip="Edit Page">
												<i class="fa fa-wrench"></i>
											</button>
											<button ng-if="edit[permission.id]" class="btn btn-danger btn-sm pull-right" ng-click="editPermission(permission)" tooltip="Cancel">
												<i class="fa fa-times"></i>
											</button>
											<button ng-if="edit[permission.id]" class="btn btn-success btn-sm pull-right" ng-click="savePermission(permission)" tooltip="Saves Changes">
												<i class="fa" ng-class="{'fa-check': !saving[permission.id], 'fa-spinner fa-spin': saving[permission.id]}"></i>
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