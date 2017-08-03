<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Simple Chat</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

        @include('frontend.layouts.sidebar')
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 main-content" >
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>




    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js"></script>

    <!-- Chat  -->


    @yield('scripts')
    @yield('added-scripts')



</body>
</html>