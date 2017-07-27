@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <div class="content  col-lg-12 " >
        <div>
            <div style="margin-bottom:20px">
                <h3 style="display:inline"><span>@</span>{!! $get_room->name !!}</h3>
                <a href="{{ route('chooseUser', $id) }}" style="float:right" class="btn btn-default">Add Member</a>
            </div>
            <div id="all_messages" style="height:500px;overflow-x: hiden;overflow-y: auto;word-wrap:break-word;" >
                <div>
                @foreach($messages as $messages)
                    @if ($messages->user->avatar != null && file_exists(public_path('/backend/images/upload/'.$messages->user->avatar))) 
                        <img style="max-width:45px;height:auto;" src="{{ url('/backend/images/upload/'.$messages->user->avatar) }}" class="img-circle"
                        alt="User Image" />
                    @else
                        <img style="max-width:45px;height:auto;" src="{{ url('/backend/no_image.jpg') }}"
                        class = "img-circle" id ="User Image" />
                    @endif
                     <span style="font-weight:bold">{!! $messages->user->username !!} :</span> 
                    <span>{!! $messages->created_at !!}</span> 
                    <p>{!! $messages->content !!}</p>
                @endforeach
                </div>
                <div id="messages"></div>
            </div>
            <div class="input-message-container">
                <form action="" method="" id="form-sub">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="room_id" id = "room_id" value="{{ $id }}">
                    <textarea cols="1" rows="1" name="message" id="message-content" class="form-control" placeholder="Message" 
                    style="width:700;float:left;resize:none;border-radius:5px"></textarea>
                    <label class="btn btn-default btn-file" style="display:inline; float:left;">
                        Choose File <input type="file" style="display: none;">
                    </label>
                    <input type="button" class="display-media btn btn-default " name="media" value="Media">
                    <button type="submit" class="btn" style="margin-left:-3px">Submit</button>
                </form>
            </div>
        </div>
    </div>


    <div class="col-lg-5 media flex hidden" >
        ádasdádasdedia
    </div>


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>

    <script type = "text/javascript">
        $(document).ready(function() {
            $('.display-media ').on('click', function (e) {
                if($('.media').hasClass('hidden')){
                    $('.media').removeClass('hidden').stop().fadeIn("slow");
                    $('.content').removeClass('col-lg-12').addClass('flex').addClass('col-lg-7');
                }
                else {
                    $('.media').addClass('hidden').stop().fadeOut("slow");
                    $('.content').removeClass('col-lg-7').removeClass('flex').addClass('col-lg-12');
                }

            });
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });

            $('#form-sub').submit(function (e) {
                e.preventDefault();

                // var message = $('#message-content').val();
                var request = $.ajax({
                    type: "get",
                    url: '/public/sendmessage',
                    data: {
                        'message' : $('#message-content').val(),
                        'room_id' : $('#room_id').val(),
                    }
                });
                //reset input & focus
                document.getElementById("message-content").value = "";
                $("#message-content").focus();

                request.done(function (response, textStatus, jqXHR){
                    //console.log("Response: " + response);
                });

                // Callback handler that will be called on failure
                request.fail(function (jqXHR, textStatus, errorThrown){
                    //console.error("error");
                });

            });
            function imageExists(url, callback) {
                var img = new Image();
                img.onload = function() { callback(true); };
                img.onerror = function() { callback(false); };
                img.src = url;
            }


            var socket = io.connect('http://localhost:8890');
            socket.on('message', function (data) {
                var message = JSON.parse(data);
                var imageUrl = window.location.origin + "/backend/images/upload/" + message.user.avatar;
                imageExists(imageUrl, function(exists) {
                    if (exists) {
                        img = "<img style='max-width:45px;height:auto;' class='img-circle' src='"+imageUrl+"'/>";
                        $( "#messages" ).append( img + "<span><strong>"+message.user.username+" :</strong> "+message.created_at+
                        "</span><p>"+message.content +"</p>" );
                    }else{
                        img ="<img style='max-width:45px;height:auto;' class='img-circle' src='{{ url("/backend/no_image.jpg") }}' />";
                        $( "#messages" ).append( img + "<span><strong>"+message.user.username+" :</strong> "+message.created_at+
                        "</span><p>"+message.content +"</p>" );
                    }
                });
                
                //auto bottom scroll
            });
            var container = $('#all_messages');
            container.scrollTop(container.get(0).scrollHeight);
            document.body.scrollTop = document.body.scrollHeight;
        });
       
    </script>
@endsection
@endsection

