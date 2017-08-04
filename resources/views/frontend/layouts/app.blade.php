<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rocket Me</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ url('/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ url('/css/style.css') }}" rel="stylesheet">
    <link href="{{ url('/css/music.css') }}" rel="stylesheet">
    <link href="{{ url('/css/video.css') }}" rel="stylesheet">

    @yield('css')
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    @include('frontend.layouts.sidebar')
@endif

        <div class="content-wrapper" style="background-color: white">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 main-content"  >
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>




    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js"></script>

    <!-- Chat  -->
<script type="text/javascript">
    function myFunction() {
        document.getElementById('display').style.display = "block";
        document.getElementById('display-sidebar').style.display = "none";
    }

    function myExit() {
        document.getElementById('display').style.display = "none";
        document.getElementById('display-sidebar').style.display = "block";
    }

    $(function () {
        $('#search').keyup(function () {
            myFunction();
            var content = $("#search").val();

            $.ajax({
                url: '{{url('search')}}',
                type: 'get',
                data: {
                    content: content,
                },
                success: function (data) {
                    console.log(data);
                    if (data.success) {

                        var user = data.users;
                        var room = data.rooms;
                        var username = user.map(function (a) {
                            var result = [];
                            result.push({id: a.id, name: a.username});
                            return result;
                        });

                        var roomname = room.map(function (a) {
                            var result = [];
                            result.push({id: a.id, name: a.name});
                            return result;
                        });
                        var content = "";
                        var roomContent = "";
                        for (var i = 0; i < username.length; i++) {
                            var obj = username[i];
                            for (var k = 0; k < obj.length; k++) {
                                var path = "/single/" + obj[k].id;
                                var url = window.location.protocol + "//" + window.location.host + path;
                                content += '<li><a href="' + url +
                                        '">'
                                        + obj[k].name
                                        + '</a></li>';
                            }
                        }
                        for (var i = 0; i < roomname.length; i++) {
                            var objroom = roomname[i];
                            for (var k = 0; k < objroom.length; k++) {
                                var path = "/room/" + objroom[k].id;
                                var url = window.location.protocol + "//" + window.location.host + path;
                                roomContent += '<li><a href="' + url +
                                        '">'
                                        + objroom[k].name
                                        + '</a></li>';
                            }
                        }
                        if (content != "" || roomContent!="") {
                            $('.myRoom').html(roomContent);
                            $('.myUser').html(content);
                        }
                        else {
                            $('.myRoom').html("");
                            $('.myUser').html("");
                        }
                    } else {
                        $('.myRoom').html("");
                        $('.myUser').html("");
                        console.log("ko co du lieu");
                    }
                },
                error: function (data) {
                    alert(data);
                }
            });

        });
    });
</script>
@yield('scripts')
@yield('added-scripts')

{{--<script src="{{ url('/js/search.js') }}"></script>--}}



</body>
</html>