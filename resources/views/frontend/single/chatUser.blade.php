@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <div class="content col-lg-12" >
        <div>
            <div id="all-mess" style="height:610px;overflow-x: hiden;overflow-y: auto;word-wrap:break-word;" >
                 <h3 style="color: blue;"><a href="">@ {{$user->username}} </a></h3>
                 <div class="user-panel">
                        <ul id="messages">
                            @foreach ($mes as $message)
                                <li> @if ($message->user->avatar != null && file_exists(public_path('/backend/images/upload/'.$message->user->avatar))) 
                                        <img
                                            style="max-width: 45px;height: auto;"
                                         src="{{ url('/backend/images/upload/'.$message->user->avatar) }}" class="img-circle"
                                         alt="User Image"
                                        />
                                    @else
                                        <img 
                                            style="max-width: 45px;height: auto;"
                                            src="{{ url('/backend/no_image.jpg') }}"
                                            class = "img-circle" id ="User Image" 
                                        />
                                    @endif<strong>{{$message->user->username}}: </strong>
                                    {{$message->created_at}}
                                    <p>{{$message->content}} </p>

                                </li>

                            @endforeach
                        </ul>
                    
                </div>
            </div>
           
            <div class="input-message-container">
                <form action="" id="form-sub">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="idCap" id="idCap" value="{{ $idCap }}">
                    <input type="button" class="display-media " name="media" value="media">
                    <textarea cols="1" rows="1" name="message" id="message-content" class="form-control" placeholder="Message"
                    style="width:835px;float:left;resize:none;border-radius:5px"></textarea>
                    <label class="btn btn-default btn-file" style="display:inline; float:left;">
                    Choose File <input type="file" style="display: none;">
                    </label>
                    <input type="submit" class="btn btn-sub" value="Submit">
                </form> 
            </div>


        </div>
    </div>
      <div class="col-lg-5 media flex hidden" >
        ádasdádasdedia
    </div>
 @section('scripts')
           <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
        <script type="text/javascript">
            $(function() {
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
                    var img = "mes";
                    var socket = io.connect('http://localhost:8890');
                     $('#form-sub').on('submit',function (e) {
                        var token = $("input[name='_token']").val();
                        var idCap = $("input[name='idCap']").val();
                        var msg = $("#message-content").val();
                        if (msg != '') {
                            $.ajax({
                                type: "POST",
                                url: '/public/sendmessageuser',
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                data: {
                                    '_token': token,
                                    'message': msg,
                                    'idCap': idCap,
                                },
                                success: function (data) {
                                    console.log(data);
                                    $("#message-content").val('');
                                },
                                error: function (data) {
                                    console.log(data);
                                }
                            });
                            return false;
                        } else {
                            alert("Please Add Message.");
                            return false;
                        }    
                    });
                        
                        var day = new Date();
                        if (day.getMonth()< 9) {
                            month = "0"+(day.getMonth() +1);
                        }else{
                            month = day.getMonth() +1;
                        }

                        var formatdate = day.getFullYear()
                                        + "-"+month+ "-"+day.getDate()+ " "+day.getHours()+ ":"+day.getMinutes()+":"+day.getSeconds();
                        var imageUrl = window.location.origin + "/backend/images/upload/";
                        socket.on("message:{{$type}}:{{$idCap}}",function(data){  
                            var url = imageUrl+ data.avatarSender;
                            function imageExists(url, callback) {
                                  var img = new Image();
                                  img.onload = function() { 
                                    var  img = "<img style='max-width:45px;height:auto;' class='img-circle' src='"+url+"'/>";
                                    callback(img);
                                     };
                                  img.onerror = function() { 
                                    var img ="<img style='max-width:45px;height:auto;' class='img-circle' src='{{ url("/backend/no_image.jpg") }}' />";
                                    callback(img);
                                     };
                                  img.src = url;
                                }
                           imageExists(url, function(images) {                   
                                    $("#messages").append("<li>"+images
                                    +"<strong>"
                                    +data.usernameSender
                                    +":</strong>"
                                    + formatdate
                                    +"<p>"
                                    +data.messages
                                    +"</p></li>" );
                                     });  
                        });
                    var container = $('#all-mess');
                    container.scrollTop(container.get(0).scrollHeight);
                    document.body.scrollTop = document.body.scrollHeight;
        });
        </script>

        @endsection
@endsection

