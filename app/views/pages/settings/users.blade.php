@extends('master')

@section('page_title')
  Users
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]] / [[ HTML::link(URL::route('settings.users'), 'Users') ]]
@stop

@section('assets')
  @parent
  [[ HTML::script('js/angular/controllers/SettingsUsersCtrl.js') ]]
@stop

@section('content')
  <div ng-controller="SettingsUsersCtrl">
    <div class="row">
      <div class="col-xs-12">
        <div class="toolbar">
          <button class="btn btn-sm btn-success pull-right" ng-click="newUser()">New User</button>
          <button class="btn btn-sm btn-info pull-right">Force Refresh</button>
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
                    <th>Enabled</th>
                    <th>Groups</th>
                    <th>Last Updated</th>
                    <th class="text-center"><i class="fa fa-cogs"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="user in users | filter:searchUsers">
                    <td class="text-center" ng-bind="user.id"></td>
                    <td ng-bind="user.nickname"></td>
                    <td ng-bind="user.community_id"></td>
                    <td ng-bind="user.enabled"></td>
                    <td></td>
                    <td ng-bind="user.updated_at"></td>
                    <td>
                      <button class="btn btn-danger" ng-click="deleteUser(user)">
                        <i class="fa fa-trash-o"></i>
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

    @include('partials.toaster')

  </div>
@stop