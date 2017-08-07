<div class="content col-lg-7 col-md-7 col-sm-6 col-xs-6 flex ">
    <div class="messages-wrapper">
        @yield('name-conv')
        <div id="all_messages" style="height:785px;overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
            <div class="message-content">
                @foreach($messages as $message)
                    <div class="client">
                        @if ($message->user->avatar != null && file_exists(public_path('/backend/images/upload/'.$message->user->avatar)))
                            <img style="max-width:45px;height:auto;"
                                 src="{{ url('/backend/images/upload/'.$message->user->avatar) }}"
                                 class="img-circle"
                                 alt="User Image"/>
                        @else
                            <img style="max-width:45px;height:auto;" src="{{ url('/backend/no_image.jpg') }}"
                                 class="img-circle" id="User Image"/>
                        @endif
                        <span style="font-weight:bold">{!! $message->user->username !!} :</span>
                        <span>{!! $message->created_at !!}</span>
                        <p>{!! \App\Helpers\Emojis::Smilify($message->content)!!}</p>
                        @if($message->media->count() > 0)
                            @foreach($message->media as $media)
                                @if( $media->type =='ytb')
                                    {!! \App\Helpers\Youtube::embededYTB($media->url,true)!!}
                                @elseif($media->type == 'image')
                                    {!! \App\Helpers\Media::embededPhoto($media->url)!!}
                                @endif
                            @endforeach
                        @else
                            {!! \App\Helpers\PreviewURL::getPreviewUrl($message->content) !!}
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="input-message-container">
            <form action="" method="" id="form-sub">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <textarea cols="1" rows="1" name="message" id="message-content" class="form-control textarea-control"
                          data-emojiable="true"
                          style="float:left;resize:none;border-radius:5px">
                </textarea>
                <input type="button" class="display-media btn btn-default" name="media" value="Media">
                <button style="margin-left:-3px" type="submit" class="btn">Submit</button>
                <div>
                    <input id="file-0" type="file" name="file" class="file" style="height:100px"
                           data-preview-file-type="text">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 media flex drop" title="{{$type}}{{$id}}">


    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#ytb-tab">Youtube</a></li>
        <li><a data-toggle="tab" href="#video-tab">Video</a></li>
        <li><a data-toggle="tab" href="#mp3-tab">Mp3</a></li>
        @yield('list_users_tab')
        <li><a data-toggle="tab" href="#webcam-tab">Webcam</a></li>


    </ul>
    <div class="tab-content media-list ">
        <div id='ytb-tab' class="tab-pane fade in active">
            <div class="ytb-list  ">
                <ul class="image-grid ytb-wrapper" id="list">
                    @foreach( $medias->where('type','ytb')->all() as $media)
                        <li>
                            {!! \App\Helpers\Youtube::embededYTB($media->url,false) !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div id='video-tab' class="tab-pane fade ">
            <div class="ytb-list ">
                <ul class="image-grid video-wrapper" id="list">
                    @foreach( $medias->where('type','video')->all() as $media)
                        <li>
                            {!!$media->name!!}
                            {!! \App\Helpers\Media::embededVideo($media->url) !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div id='mp3-tab' class="tab-pane fade">
            <div class="ytb-list ">
                <ul class="image-grid music-wrapper" id="list">
                    @foreach( $medias->where('type','mp3')->all() as $media)
                        <li>
                            {!!$media->name!!}
                            {!! \App\Helpers\Media::embededMusic($media->url) !!}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @yield('list_users')
        <div id='webcam-tab' class="tab-pane fade ">
            <div class="ytb-list ">
                <div id="my_camera"></div>
                <input type="button" id="attach" class="attach" value="Start Webcam">
                <input type=button value="Take Snapshot" id='snap'>
            </div>
        </div>

    </div>
    <div class="love-mes form-group">
        <form id="love-mes-form" action="" method="">
            <input type="text" class="form-control" id="love-mes-input'" placeholder="type here and hit enter to see the magic ^^">
        </form>
    </div>
    <div class="sticker-list ">
        <div id='sticker-tab'>
            <div class="sticker-list-wrapper  media-list ">
                @foreach( \App\Models\Emoji::all() as $emoji)
                    <div class="drag"
                         style="display: inline-block; width: 80px;"> {!! \App\Helpers\Sticker::embededSticker($emoji->url) !!}</div>
                @endforeach

            </div>
        </div>
        <div>
            <form action="" id="custom-text">
                <input type="text" value="" placeholder="type here to custom text sticker" style="width: 215px;">
                <div style="display:inline-block;"><img class='bin' id='st{{str_random(6)}}'
                                                        src='{{url('storage/sticker')}}/bin.png' style='width : 80px;'> <--Drag here to delete sticker
                </div> </br>
                <span class="glyphicon glyphicon-play sticker-play"
                                                   style="font-size: 25px; display: inline-block;"></span> <-- Click here to start playing sticker

            </form>

        </div>
    </div>

</div>
<div class="amination" hidden>
    <img src="{{url('effect')}}/many-little-heart-make-big-heart-gif.gif"/>
</div>

@section('added-scripts')
    <script src="{{ url('/js/fileinput.js') }}"></script>
    <script>
        $("#file-0").fileinput();
        var channel = $('.media').attr('title');
        var node_url = '{{Config::get('constants.url.nodejs')}}';

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>
    <script src="{{url("js/jquery.js")}}"></script>
    <script src="{{url("js/jquery-ui.js")}}"></script>
    <script src="{{url("js/jquery.simulate.js")}}"></script>
    <script src="{{ url('/js/music.js') }}"></script>
    <script src="{{ url('/js/video.js') }}"></script>
    <script src="{{ url('/js/jquery.lettering-0.6.1.min.js') }}"></script>
    <script src="{{ url('/js/jQueryRotate.js') }}"></script>
    <script src="{{ url('/js/webcam.js') }}"></script>
    <script src="{{ url('/js/custom.js') }}"></script>

    <script language="JavaScript">
        function makeid() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 9; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        $('#attach').click(function () {
            if ($(this).hasClass('attach')) {
                Webcam.attach('#my_camera');
                $(this).val('Stop Webcam');
                $(this).removeClass('attach');
                $(this).addClass('detach');
            }
            else {
                Webcam.reset('#my_camera');
                $(this).val('Start Webcam');
                $(this).removeClass('detach');
                $(this).addClass('attach');

            }

        });


    </script>
    <script language="JavaScript">
        var data_uri;
        $('#snap').click(function (e) {
            Webcam.snap(function (data_uri) {
                data_uri = data_uri;
                var left = Math.floor(Math.random() * 300) + 15;
                var top = Math.floor(Math.random() * 300) + 15;
                var name = makeid();

                Webcam.upload(data_uri, '{!!  url('webcam_upload?format=jpg&name=')!!}' + name, function (code, text) {
                    var content = "<div class='drag inside-drop-zone'  style=' position: absolute; left: " + left + "px; top: " + top + "px; width:80px'>" +
                            "<img class='sticker' id='st" + name + "' src='{{url('storage/sticker')}}/" + name + ".jpg' style='width : 80px;' ></div>";
                    $('.drop').append(content);
                    $('.drop>.drag').draggable();
                    socket_general.emit('sticker', channel, content);
                });
            });

            e.preventDefault();
        })


    </script>

@endsection