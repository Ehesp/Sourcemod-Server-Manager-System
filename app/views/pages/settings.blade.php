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
          @if(Permissions::validate('settings.users'))
            <a href="[[ URL::route('settings.users') ]]" class="pull-right">
              Manage
            </a>
          @endif
        </div>
        <div class="widget-body medium no-padding">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th class="text-center">ID</th>
                  <th>Nickname</th>
                  <th>Community ID</th>
                  <th class="text-center">Enabled</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                  <tr>
                    <td class="text-center">[[ $user->id ]]</td>
                    <td>[[ $user->nickname ]]</td>
                    <td>[[ $user->community_id ]]</td>
                    <td class="text-center">
                      @if ($user->enabled == 1)
                        <i class="fa fa-check"></i>
                      @else
                        <i class="fa fa-times"></i>
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title">
          <i class="fa fa-cogs"></i> SSMS Options
          @if(Permissions::validate('settings.options'))
            <a href="[[ URL::route('settings.options') ]]" class="pull-right">
              Manage
            </a>
          @endif
        </div>
        <div class="widget-body medium no-padding">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>Option</th>
                  <th></th>
                </tr>
              </thead>
              <tbody class="tbody-medium">
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
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title">
          <i class="fa fa-key"></i> Page Management
          @if(Permissions::validate('settings.page_management'))
            <a href="[[ URL::route('settings.page-management') ]]" class="pull-right">
              Manage
            </a>
          @endif
        </div>
        <div class="widget-body no-padding">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Icon</th>
                  <th>Slug</th>
                </tr>
              </thead>
              <tbody>
                @foreach($page_access as $access)
                  <tr>
                    <td>[[ $access->friendly_name ]]</td>
                    <td><i class="[[ $access->icon ]]"></i></td>
                    <td>[[ $access->slug ]]</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title">
          <i class="fa fa-unlock-alt"></i> Permission Control
          @if(Permissions::validate('settings.permission_control'))
            <a href="[[ URL::route('settings.permission-control') ]]" class="pull-right">
              Manage
            </a>
          @endif
        </div>
        <div class="widget-body medium no-padding">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>Permission</th>
                  <th>Description</th>
                  <th>Page</th>
                </tr>
              </thead>
              <tbody>
                @foreach($permission_control as $permission)
                  <tr>
                    <td>[[ $permission->name ]]</td>
                    <td>[[ $permission->description ]]</td>
                    <td>[[ $permission->page->friendly_name ]]</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
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
          <div class="table-responsive">
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
  </div>
@stop