<div class="content col-lg-12 ">
    <div class="messages-wrapper">
        @yield('name-conv')
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
                            @if( $media->type ='ytb')
                            {!! \App\Helpers\Youtube::embededYTB($media->url)!!}
                                @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="input-message-container">
            <form action="" method="" id="form-sub">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="button" class="display-media " name="media" value="media">
                    <textarea cols="1" rows="1" name="message" id="message-content" class="form-control"
                              placeholder="Message"
                              style="width:780px;float:left;resize:none;border-radius:5px"></textarea>
                <label class="btn btn-default btn-file" style="display:inline; float:left;">
                    Choose File <input type="file" style="display: none;">
                </label>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </div>
</div>


<div class="col-lg-5 media flex hidden">
    <div class="media-list">
        <div class="ytb-list">
            <ul class="image-grid" id="list">
                @foreach( $medias->where('type','ytb')->all() as $media)
                    <li>
                        {!! \App\Helpers\Youtube::embededYTB($media->url) !!}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="name-media-list">

    </div>
</div>