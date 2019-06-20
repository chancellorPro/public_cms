<div class="left_col_public">
    <div class="left_col scroll-view">

        <div class="x_panel">
            <h3>Categories</h3>
        </div>


        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu x_panel"
             style="margin-top:4px; padding-left: 0;padding-right: 0">
            <div class="menu-section">
                @yield('categories')
            </div>
        </div>
        <!-- /sidebar menu -->
        
        <!-- /menu footer buttons -->
<!--        <div class="sidebar-footer hidden-small">
            <a>
                <span class="glyphicon"></span>
            </a>
            <a>
                <span class="glyphicon"></span>
            </a>
            <a>
                <span class="glyphicon"></span>
            </a>

            <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>-->
        <!-- /menu footer buttons -->
    </div>
</div>
