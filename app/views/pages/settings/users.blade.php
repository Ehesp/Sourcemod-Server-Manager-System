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
  <div class="row">
    <div class="col-lg-12">
      <div class="widget" ng-controller="SettingsUsersCtrl">
        <div class="widget-title">
          <i class="fa fa-users"></i> Manage Users
        </div>
        <div class="widget-body no-padding">

          <loading></loading>

          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center">ID</th>
                  <th>Nickname</th>
                  <th>Community ID</th>
                  <th>Enabled</th>
                  <th>Groups</th>
                  <th>Created</th>
                  <th>Last Updated</th>
                  <th class="text-center"><i class="fa fa-cogs"></i></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td class="text-center">[[ $user->id ]]</td>
                    <td>[[ $user->nickname ]]</td>
                    <td>[[ $user->community_id ]]</td>
                    <td>[[ $user->enabled ]]</td>
                    <td></td>
                    <td>[[ $user->updated_at ]]</td>
                    <td>
                      <button class="btn btn-sm btn-warning"><i class="fa fa-refresh"></i></button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop