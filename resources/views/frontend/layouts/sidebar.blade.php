<aside class="main-sidebar" id="sidebar-wrapper" style ="background-color:#04436a">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if (Auth::user()->avatar != null && file_exists(public_path('/backend/images/upload/'.Auth::user()->avatar))) 
                    <img src="{{ url('/backend/images/upload/'.Auth::user()->avatar) }}" class="img-circle"
                     alt="User Image" />
                @else
                    <img src="{{ url('/backend/no_image.jpg') }}"
                    class = "img-circle" id ="User Image" /><br>
                @endif
            </div>
            <div class="pull-left info">
                @if (Auth::guest())
                <p>InfyOm</p>
                @else
                    <a href="{{ route('profileUser') }}" style="font-size:14px">{{ Auth::user()->username}}</a>
                @endif
                <!-- Status -->
                <div>
                    <i class="fa fa-circle text-success"></i> Online
                </div>
            </div>
        </div>
        <form action="{{ route('search') }}" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="search_ip" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- Sidebar Menu -->

        <ul class="sidebar-menu" style="height:250px;
        overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
            @widget('listRooms')
        </ul>
        <!-- /.sidebar-menu -->
        <ul class="sidebar-menu" style="height:210px;
        overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
            @widget('listUsers')
        </ul>

        
    </section>
    <!-- /.sidebar -->
    <div class="pull-right" style="margin:10px;">
        <a href="{!! route('logoutPublic') !!}" class="btn btn-default btn-flat"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sign out
        </a>
        <form id="logout-form" action="{{ route('logoutPublic') }}" method="get" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</aside>