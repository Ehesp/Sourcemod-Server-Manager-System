<ul class="sidebar">
  <li class="sidebar-main">
    <a href="#" ng-click="toggleSidebar()">
      SSMS 
      <span class="menu-icon glyphicon glyphicon-transfer"></span>
    </a>
  </li>
  <li class="sidebar-title"><span>NAVIGATION</span></li>
  @foreach($sidebarPages as $page)
    <li class="sidebar-list">
      <a href="[[ URL::to($page->slug) ]]">[[ $page->friendly_name ]] <span class="menu-icon [[ $page->icon ]]" title="[[ $page->friendly_name ]]"></span></a>
    </li>
  @endforeach
  @if(count($quickLinks) != 0)
    <li class="sidebar-title separator"><span>QUICK LINKS</span></li>
    @foreach($quickLinks as $link)
      <li class="sidebar-list">
        <a href="[[ $link->url ]]" target="_blank">[[ $link->name ]] <span class="menu-icon [[ $link->icon ]]"></span></a>
      </li>
    @endforeach
  @endif
</ul>
<div class="sidebar-footer">
  <div class="col-xs-4">
    <a href="https://github.com/Ehesp/Sourcemod-Server-Manager-System" target="_blank">
      Github
    </a>
  </div>
  <div class="col-xs-4">
    <a href="http://lethal-zone.eu/donate" target="_blank">
      Donate
    </a>
  </div>
  <div class="col-xs-4">
    <a href="#">
      Steam
    </a>
  </div>
</div>