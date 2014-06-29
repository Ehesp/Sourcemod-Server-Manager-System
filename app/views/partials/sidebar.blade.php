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
      <a href="[[ URL::to($page->slug) ]]">[[ $page->friendly_name ]] <span class="menu-icon [[ $page->icon ]]"></span></a>
    </li>
  @endforeach
  <li class="sidebar-title separator"><span>QUICK LINKS</span></li>
  <li class="sidebar-list">
    <a href="#">
      Forums <span class="menu-icon fa fa-external-link"></span>
    </a>
  </li>
  <li class="sidebar-list">
    <a href="#">
      IRC <span class="menu-icon fa fa-comment"></span>
    </a>
  </li>
</ul>
<div class="sidebar-footer">
  <div class="col-xs-4">
    <a href="https://github.com/Ehesp/Sourcemod-Server-Manager-System">
      Github
    </a>
  </div>
  <div class="col-xs-4">
    <a href="#">
      Support
    </a>
  </div>
  <div class="col-xs-4">
    <a href="#">
      Steam
    </a>
  </div>
</div>