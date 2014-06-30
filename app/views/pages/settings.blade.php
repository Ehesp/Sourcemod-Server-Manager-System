@extends('master')

@section('page_title')
  Settings
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link(URL::route('settings'), 'Settings') ]]
@stop

@section('content')
  <div class="row">
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title">
          <i class="fa fa-users"></i> SSMS Users
          <a href="#" class="pull-right">
            Manage
          </a>
        </div>
        <div class="widget-body no-padding">
          <table class="table">
            <thead>
              <tr>
                <th class="text-center">ID</th>
                <th>Nickname</th>
                <th>Community ID</th>
                <th>Enabled</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
                <tr>
                  <td class="text-center">[[ $user->id ]]</td>
                  <td>[[ $user->nickname ]]</td>
                  <td>[[ $user->community_id ]]</td>
                  <td>[[ $user->enabled ]]</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title">
          <i class="fa fa-cogs"></i> SSMS Options
          <a href="#" class="pull-right">
            Manage
          </a>
        </div>
        <div class="widget-body no-padding">
          <table class="table">
            <thead>
              <tr>
                <th>Option</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($options as $option)
                <tr>
                  <td>[[ $option->friendly_name ]]</td>
                  <td>[[ $option->value ]]</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title">
          <i class="fa fa-external-link-square"></i> Quick Links
          <a href="#" class="pull-right">
            Manage
          </a>
        </div>
        <div class="widget-body no-padding">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Title</th>
                <th>URL</th>
              </tr>
            </thead>
            <tbody>
              @foreach($quick_links as $link)
                <tr>
                  <td>[[ $link->name ]]</td>
                  <td>[[ $link->url ]]</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title">
          <i class="fa fa-unlock-alt"></i> Access Control
          <a href="#" class="pull-right">
            Manage
          </a>
        </div>
        <div class="widget-body no-padding">
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>Page</th>
                <th>Link</th>
                <th>Icon</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@stop