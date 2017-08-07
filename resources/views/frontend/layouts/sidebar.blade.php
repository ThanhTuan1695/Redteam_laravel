<aside class="main-sidebar" id="sidebar-wrapper" style="background-color:#04436a">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if (Auth::user()->avatar != null && file_exists(public_path('/backend/images/upload/'.Auth::user()->avatar)))
                    <img src="{{ url('/backend/images/upload/'.Auth::user()->avatar) }}" class="img-circle"
                         alt="User Image"/>
                @else
                    <img src="{{ url('/backend/no_image.jpg') }}"
                         class="img-circle" id="User Image"/><br>
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

        <form action="" id="#search-form">
            <input type="text" class="btn btn-flat" name="search"
                   id="search" value=""/>
            <button type="reset" class="fa fa-times" id="exit" name="exit" onclick="myExit()"></button>

        <!-- Sidebar Menu -->
        <div id="display-sidebar">
            <ul class="sidebar-menu" style="height:250px;
        overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
                @widget('listRooms')
            </ul>
            <!-- /.sidebar-menu -->
            <ul class="sidebar-menu" style="height:210px;
        overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
                @widget('listUsers')
            </ul>
        </div>

        <div class="result-search" id="display" hidden>
            <ul class="sidebar-menu mystyle myRoom">

            </ul>
            <ul class="sidebar-menu mystyle myUser">

            </ul>
        </div>

    </section>
    <!-- /.sidebar -->
    <div class="pull-right" style="margin:10px;">
        <a href="{!! route('logoutPublic') !!}" class="btn btn-default btn-flat">
            Sign out
        </a>
        <form id="logout-form" action="{{ route('logoutPublic') }}" method="get" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</aside>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous">
</script>

