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
                <th>ID</th>
                <th>Nickname</th>
                <th>Community ID</th>
                <th>Group</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>|LZ| Alias</td>
                <td>123456789</td>
                <td>Admin</td>
              </tr>
              <tr>
                <td>2</td>
                <td>|LZ| Alias</td>
                <td>123456789</td>
                <td>Admin</td>
              </tr>
              <tr>
                <td>3</td>
                <td>|LZ| Alias</td>
                <td>123456789</td>
                <td>Admin</td>
              </tr>
              <tr>
                <td>4</td>
                <td>|LZ| Alias</td>
                <td>123456789</td>
                <td>Admin</td>
              </tr>
              <tr>
                <td>5</td>
                <td>|LZ| Alias</td>
                <td>123456789</td>
                <td>Admin</td>
              </tr>
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
              <tr>
                <td>Default Language</td>
                <td>English</td>
              </tr>
              <tr>
                <td>Site Title</td>
                <td>SSMS</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4">
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
                <th>Link</th>
                <th>Icon</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Forums</td>
                <td>http://lethal-zone.eu/forum</td>
                <td>fa-external-link</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
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
              <tr>
                <td>Forums</td>
                <td>http://lethal-zone.eu/forum</td>
                <td>fa-external-link</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@stop