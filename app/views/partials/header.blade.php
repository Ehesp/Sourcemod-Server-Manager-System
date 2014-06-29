<div class="row header">
  <div class="col-xs-12">
    <div class="meta pull-left">
      <div class="page">
        @yield('page_title', Lang::get('header.defaultTitle'))
      </div>
      <div class="breadcrumb-links">
        @yield('page_breadcrumb', Lang::get('header.defaultBreadcrumb'))
      </div>
    </div>
    @if(Auth::check())
    <div class="user pull-right">
      <div class="item dropdown">
        <a href="#" class="dropdown-toggle">
          <img src="[[ Auth::user()->avatar ]]">
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li class="dropdown-header">
            [[ Auth::user()->nickname ]]
          </li>
          <li class="divider"></li>
          <li class="link">
            <a href="#">
              @lang('header.yourProfile')
            </a>
          </li>
          <li class="link">
            <a href="http://steamcommunity.com/profiles/[[ Auth::user()->community_id ]]" target="_blank">
              @lang('header.steamProfile')
            </a>
          </li>
          <li class="link">
            <a href="http://steamrep.com/profiles/[[ Auth::user()->community_id ]]" target="_blank">
              @lang('header.steamRep')
            </a>
          </li>
          <li class="divider"></li>
          <li class="link">
            <a href="[[ URL::to('logout') ]]">
              @lang('header.logout')
            </a>
          </li>
        </ul>               
      </div>
      <div class="item dropdown">
       <a href="#" class="dropdown-toggle">
          <i class="fa fa-bell-o"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li class="dropdown-header">
            @lang('header.notifications')
          </li>
          <li>
            <a href="#">Bell</a>
          </li>
        </ul>
      </div>
    </div>
    @else
    <div class="login pull-right">
      <a href="[[ $steamLoginUrl ]]">
        [[ HTML::image('img/steam/login-sm.png', 'Steam Login') ]]
      </a>
    </div>
    @endif
  </div>
</div>