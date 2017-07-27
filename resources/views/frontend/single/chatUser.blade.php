@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <div class="content col-lg-12">
        <div class="messages-wrapper">
            <div class="name-conv" style="margin-bottom:20px">
                <h3 style="display:inline"><span>@</span>{!! $user->username !!}</h3>
            </div>
            <div id="all_messages" style="height:580px;overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
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
                            <p>{!! \App\Helpers\Emojis::Smilify($message->content) !!}</p>

                            @foreach($message->media as $media)
                                {!! \App\Helpers\Youtube::embededYTB($media->url)!!}
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="input-message-container">
                <form action="" id="form-sub">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="button" class="display-media " name="media" value="media">
                    <textarea cols="1" rows="1" name="message" id="message-content" class="form-control"
                              placeholder="Message"
                              style="width:835px;float:left;resize:none;border-radius:5px"></textarea>
                    <label class="btn btn-default btn-file" style="display:inline; float:left;">
                        Choose File <input type="file" style="display: none;">
                    </label>
                    <input type="submit" class="btn btn-sub" value="Submit">
                </form>
            </div>


        </div>
    </div>
    <div class="col-lg-5 media flex hidden">
        ádasdádasdedia
    </div>
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
    <script type="text/javascript">
        $(function () {
            $('.display-media ').on('click', function (e) {
                if ($('.media').hasClass('hidden')) {
                    $('.media').removeClass('hidden').stop().fadeIn("slow");
                    $('.content').removeClass('col-lg-12').addClass('flex').addClass('col-lg-7');
                }
                else {
                    $('.media').addClass('hidden').stop().fadeOut("slow");
                    $('.content').removeClass('col-lg-7').removeClass('flex').addClass('col-lg-12');
                }
            });

            $('#form-sub').on('submit', function (e) {
                var token = $("input[name='_token']").val();
                var msg = $("#message-content").val();
                if (msg != '') {
                    $.ajax({
                        type: "POST",
                        url: '/public/sendmessageuser',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            '_token': token,
                            'message': msg,
                            'id': '{{$id}}',
                        },
                        success: function (data) {
                            console.log(data);
                            $("#message-content").val('');
                        },
                        error: function (data) {
                            console.log('error');
                        }
                    });
                    return false;
                } else {
                    alert("Please Add Message.");
                    return false;
                }
            });

            var socket = io.connect('http://localhost:8890');
            socket.on("message:{{$type}}:{{$id}}", function (data) {
                $(".message-content").append(data.content);
                //auto bottom scroll
            });
            var container = $('#all-mess');
            container.scrollTop(container.get(0).scrollHeight);
            document.body.scrollTop = document.body.scrollHeight;
        });
    </script>

@endsection
@endsection

