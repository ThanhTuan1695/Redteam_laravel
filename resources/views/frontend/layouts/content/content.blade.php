<div class="content col-lg-7 flex ">
    <div class="messages-wrapper">
        @yield('name-conv')
        <div id="all_messages" style="height:480px;overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
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
                            @if( $media->type =='ytb')
                                {!! \App\Helpers\Youtube::embededYTB($media->url,true)!!}
                            @endif

                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="input-message-container">
            <form action="" method="" id="form-sub">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <textarea cols="1" rows="1" name="message" id="message-content" class="form-control"
                          style="width:550px;float:left;resize:none;border-radius:5px">
                </textarea>
                <input type="button" class="display-media btn btn-default" name="media" value="Media">
                <button style="margin-left:-3px" type="submit" class="btn">Submit</button>
                <div style="width:687px">
                    <input id="file-0" type="file" name="file" class="file" style="height:100px" data-preview-file-type="text">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="col-lg-5 media flex" title="{{$type}}{{$id}}">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#ytb-tab">Youtube</a></li>
        <li><a data-toggle="tab" href="#video-tab">Video</a></li>
        <li><a data-toggle="tab" href="#mp3-tab">Mp3</a></li>
        @yield('list_users_tab')
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
    </div>
    <div class="love-mes form-group">
        <form id="love-mes-form" action="" method="">
            <input type="text" class="form-control" id="love-mes-input'">
        </form>
    </div>
    <div class="name-media-list">
    </div>
</div>
<div class="amination" hidden>
    <img src="{{url('effect')}}/many-little-heart-make-big-heart-gif.gif"/>

</div>

{{--<section class="ani-container" hidden>--}}
{{--<h1>--}}
{{--<span class="ani-title">This is</span>--}}
{{--<span class="ani-title">a long</span>--}}
{{--<span class="ani-title">long title</span>--}}
{{--</h1>--}}

{{--</section>--}}
