@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <div class="content" >
        <div class="container " style="float:left; max-width:1300px">
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
                    <textarea cols="1" rows="1" name="message" id="message-content" class="form-control" placeholder="Message"
                    style="width:835px;float:left;resize:none;border-radius:5px"></textarea>
                    <label class="btn btn-default btn-file" style="display:inline; float:left;">
                    Choose File <input type="file" style="display: none;">
                    </label>
                    <input type="submit" class="btn btn-sub" value="Submit">
                </form> 
            </div>
            @section('scripts')
               <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
            <script type="text/javascript">
                $(function() {
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

                    function imageExists(url, callback) {
                      var img = new Image();
                      img.onload = function() { callback(true); };
                      img.onerror = function() { callback(false); };
                      img.src = url;
                    }

                   
                    var imageUrl = window.location.origin + "/backend/images/upload/" + "{{Auth::user()->avatar}}";
                    imageExists(imageUrl, function(exists) {
                        if (exists) {
                           img = "<img style='max-width:45px;height:auto;' class='img-circle' src='"+imageUrl+"'/>";
                           
                        }else{
                            img ="<img style='max-width:45px;height:auto;' class='img-circle' src='{{ url("/backend/no_image.jpg") }}' />";
                            
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
                  
                    socket.on("message:{{$type}}:{{$idCap}}",function(data){    
                          $("#messages").append("<li>"+img
                            +"<strong>"
                            +"{{Auth::user()->username}}"
                            +":</strong>"
                            + formatdate
                            +"<p>"
                            +data.messages
                            +"</p></li>" );
                });
                var container = $('#all-mess');
                container.scrollTop(container.get(0).scrollHeight);
                document.body.scrollTop = document.body.scrollHeight;
            </script>

            @endsection

        </div>
    </div>
    
@endsection

