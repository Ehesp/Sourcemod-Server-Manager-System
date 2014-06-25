@extends('master')

@section('page_title')
  Dashboard
@stop

@section('page_breadcrumb')
  [[ HTML::link('/', 'SSMS') ]] / [[ HTML::link('dashboard', 'Dashboard') ]]
@stop

@section('content')
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="widget">
        <div class="widget-body">
          <div class="widget-icon green pull-left">
            <i class="fa fa-users"></i>
          </div>
          <div class="widget-content pull-left">
            <div class="title">145</div>
            <div class="comment">SSMS Users</div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="widget">
        <div class="widget-body">
          <div class="widget-icon red pull-left">
            <i class="fa fa-tasks"></i>
          </div>
          <div class="widget-content pull-left">
            <div class="title">30</div>
            <div class="comment">Servers</div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-xs-6">
      <div class="widget">
        <div class="widget-body">
          <div class="widget-icon orange pull-left">
            <i class="fa fa-sitemap"></i>
          </div>
          <div class="widget-content pull-left">
            <div class="title">150</div>
            <div class="comment">Active Plugins</div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="spacer visible-xs"></div>
    <div class="col-lg-3 col-xs-6">
      <div class="widget">
        <div class="widget-body">
          <div class="widget-icon blue pull-left">
            <i class="fa fa-gamepad"></i>
          </div>
          <div class="widget-content pull-left">
            <div class="title">4</div>
            <div class="comment">Game Types</div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title"><i class="fa fa-cubes"></i> Game Servers</div>
        <div class="widget-body no-padding">
          <table class="table">
            <tbody>
              <tr>
                <td>Server Name</td>
                <td>0/32</td>
              </tr>                    <tr>
                <td>Server Name</td>
                <td>0/32</td>
              </tr>                    <tr>
                <td>Server Name</td>
                <td>0/32</td>
              </tr>                    <tr>
                <td>Server Name</td>
                <td>0/32</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="widget">
        <div class="widget-title"><i class="fa fa-cubes"></i> Game Servers</div>
        <div class="widget-body">Body</div>
      </div>
    </div>
  </div>
@stop