@extends('master')

@section('page_title')
  Quick Links
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]] / [[ HTML::link(URL::route('settings.quick-links'), 'Quick Links') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/settings/SettingsQuickLinksCtrl.js') ]]
@stop

@section('content')
	<div ng-controller="SettingsQuickLinksCtrl">
		<div class="row">
			<div class="col-lg-12">
				<div class="widget">
					<div class="widget-title">
						<i class="fa fa-external-link-square"></i> Manage Quick Links
						<input type="text" class="form-control input-sm pull-right" placeholder="Search..." ng-model="searchQuickLinks">
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
										<th>URL</th>
										<th>Icon (<a target="_blank" href="http://fontawesome.io/icons/">Font Awesome</a>)</th>
										<th class="text-right"><i class="fa fa-cog"></i></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input class="form-control input-sm" type="text" ng-change="validate(newlink)" ng-model="newlink.name" placeholder="Google" />
										</td>
										<td>
											<input class="form-control input-sm" type="text" ng-change="validate(newlink)" ng-model="newlink.url" placeholder="http://google.com" />
										</td>
										<td>
											<input class="form-control input-sm" type="text" ng-change="validate(newlink)" ng-model="newlink.icon" placeholder="fa fa-google" />
										</td>
										<td>
											<button ng-disabled="disabled" class="btn btn-success btn-sm pull-right" ng-click="addLink(newlink)" tooltip="Add Link">
												<i class="fa" ng-class="{'fa-plus': !adding, 'fa-spinner fa-spin': adding}"></i>
											</button>
										</td>
									</tr>
									 <tr ng-repeat="link in links | filter:searchQuickLinks">
										<td ng-if="!edit[link.id]" ng-bind="link.name"></td>
										<td ng-if="edit[link.id]">
											<input class="form-control" type="text" ng-init="link.edit.name = link.name" ng-model="link.edit.name" />
										</td>
										<td ng-if="!edit[link.id]" ng-bind="link.url"></td>
										<td ng-if="edit[link.id]">
											<input class="form-control" type="text" ng-init="link.edit.url = link.url" ng-model="link.edit.url" />
										</td>
										<td ng-if="!edit[link.id]">
											<i class="{{ link.icon }}"></i>
										</td>
										<td ng-if="edit[link.id]">
											<input class="form-control" type="text" ng-init="link.edit.icon = link.icon" ng-model="link.edit.icon" />
										</td>
									 	<td>
											<button ng-if="!edit[link.id]" class="btn btn-warning btn-sm pull-right" ng-click="editLink(link)" tooltip="Edit Link">
												<i class="fa fa-wrench"></i>
											</button>
											<button ng-if="!edit[link.id]" class="btn btn-danger btn-sm pull-right" ng-click="deleteLink(link)" tooltip="Delete Link">
												<i class="fa fa-trash-o"></i>
											</button>
											<button ng-if="edit[link.id]" class="btn btn-danger btn-sm pull-right" ng-click="editLink(link)" tooltip="Cancel">
												<i class="fa fa-times"></i>
											</button>
											<button ng-if="edit[link.id]" class="btn btn-success btn-sm pull-right" ng-click="saveLink(link)" tooltip="Saves Changes">
												<i class="fa" ng-class="{'fa-check': !saving[link.id], 'fa-spinner fa-spin': saving[link.id]}"></i>
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