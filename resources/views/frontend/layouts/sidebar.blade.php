<aside class="main-sidebar" id="sidebar-wrapper" style ="background-color:#04436a">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if (file_exists(public_path('/backend/images/upload/'.Auth::user()->avatar)))
                    <img src="{{ url('/backend/images/upload/'.Auth::user()->avatar) }}" class="img-circle"
                     alt="User Image"/>
                @else
                    < src="{{ url('/backend/no_image.jpg') }}"
                    class = "img-circle" id ="User Image"></img><br>
                @endif
            </div>
            <div class="pull-left info">
                @if (Auth::guest())
                <p>InfyOm</p>
                @else
                    <p>{{ Auth::user()->username}}</p>
                @endif
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Sidebar Menu -->

        <ul class="sidebar-menu" style="height:320px;
        overflow-x: hiden;overflow-y: auto;word-wrap:break-word;">
            @include('frontend.layouts.menu')
        </ul>
        <!-- /.sidebar-menu -->
        <ul class="sidebar-menu" style="height:200px;
        overflow-x: hiden;overflow-y: auto;word-wrap:break-word;">
            @include('frontend.layouts.listuser')
        </ul>

        
    </section>
    <!-- /.sidebar -->
    <div class="pull-right">
        <a href="{!! route('logoutPublic') !!}" class="btn btn-default btn-flat"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Sign out
        </a>
        <form id="logout-form" action="{{ route('logoutPublic') }}" method="get" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</aside>