@extends('master')

@section('page_title')
  Users
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]] / [[ HTML::link(URL::route('settings.users'), 'Users') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/settings/SettingsUsersCtrl.js') ]]
@stop

@section('content')
  <div ng-controller="SettingsUsersCtrl">
    <div class="row">
      <div class="col-xs-12">
        <div class="toolbar">
          @if(Permissions::validate('settings.users.add'))
            <button class="btn btn-sm btn-success pull-right" ng-click="addUser()">Add User(s)</button>
          @endif
          @if(Permissions::validate('settings.users.refresh'))
          <button ng-if="!mass" class="btn btn-sm btn-info pull-right" ng-click="massRefresh()">Mass Refresh</button>
          <button ng-if="mass" type="submit" class="btn btn-sm btn-info pull-right" disabled="disabled"><i class="fa fa-spinner fa-spin"></i> Refreshing users...</button>
          @endif
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="widget">
          <div class="widget-title">
            <i class="fa fa-users"></i> Manage Users
            <input type="text" class="form-control input-sm pull-right" placeholder="Search..." ng-model="searchUsers">
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
                    <th class="text-center">ID</th>
                    <th>Nickname</th>
                    <th>Community ID</th>
                    <th>Roles</th>
                    <th>Enabled</th>
                    <th>Last Updated</th>
                    <th class="text-right"><i class="fa fa-cogs"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="user in users | filter:searchUsers">
                    <td class="text-center" ng-bind="user.id"></td>
                    <td ng-bind="user.nickname"></td>
                    <td ng-bind="user.community_id"></td>
                    [[-- Roles --]]
                    <td ng-if="!edit[user.id]">
                      <span class="roles" ng-repeat="role in user.roles" ng-switch="role.name">
                        <i ng-switch-when="super_admin" class="fa fa-star" tooltip="Super Admin"></i>
                        <i ng-switch-when="admin" class="fa fa-star-half-empty" tooltip="Admin"></i>
                        <i ng-switch-when="user" class="fa fa-star-o" tooltip="User"></i>
                        <i ng-switch-when="guest" class="fa fa-user" tooltip="Guest"></i>
                      </span>
                    </td>
                    <td ng-if="edit[user.id]">
                      <select multiple ng-multiple="true" class="form-control input-sm" ng-init="user.edit.role = selectedRoles[user.id]" ng-model="user.edit.role" ng-options="r.friendly_name for r in roles"></select>
                    </td>
                    [[-- State --]]
                    <td ng-switch="user.enabled" ng-if="!edit[user.id]">
                      <i ng-switch-when="1" class="fa fa-check"></i>
                      <i ng-switch-when="0" class="fa fa-times"></i>
                    </td>
                    <td ng-if="edit[user.id]">
                      <select class="form-control input-sm" ng-init="user.edit.state = states[user.enabled].value" ng-model="user.edit.state" ng-options="s.value as s.name for s in states"></select>
                    </td>
                    <td ng-bind="user.updated_at"></td>
                    <td>
                      @if(Permissions::validate('settings.users.edit'))
                        <button ng-if="!edit[user.id]" class="btn btn-warning btn-sm pull-right" ng-click="editUser(user)" tooltip="Edit User">
                          <i class="fa fa-wrench"></i>
                        </button>
                        <button ng-if="edit[user.id]" class="btn btn-danger btn-sm pull-right" ng-click="editUser(user)" tooltip="Cancel">
                          <i class="fa fa-times"></i>
                        </button>
                        <button ng-if="edit[user.id]" class="btn btn-success btn-sm pull-right" ng-click="saveEdit(user)" tooltip="Saves Changes">
                          <i class="fa" ng-class="{'fa-check': !saving[user.id], 'fa-spinner fa-spin': saving[user.id]}"></i>
                        </button>
                      @endif
                      @if(Permissions::validate('settings.users.delete'))
                        <button ng-if="!edit[user.id]" class="btn btn-danger btn-sm pull-right" ng-click="deleteUser(user)" tooltip="Delete User">
                          <i class="fa fa-trash-o"></i>
                        </button>
                      @endif
                      @if(Permissions::validate('settings.users.refresh'))
                        <button ng-if="!edit[user.id]" class="btn btn-info btn-sm pull-right" ng-click="refreshUser(user)" tooltip="Refresh User">
                          <i class="fa fa-refresh" ng-class="{'fa-spin': refreshing[user.id]}"></i>
                        </button>
                      @endif
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