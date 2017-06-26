<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left info">
                <p>{{$user->name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @foreach($user->menuItems as $menuItem)
                <li><a href="{{$menuItem->link}}">{{$menuItem->text}}</a></li>
            @endforeach
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>