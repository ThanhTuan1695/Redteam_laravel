<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
<script src="http://www.youtube.com/player_api"></script>

<script type="text/javascript">
    var socket = io('http://localhost:8890');
    function scroll(element) {
        $(element).animate({
            scrollTop: $(element)[0].scrollHeight
        });
    }
    scroll($('#all_messages'));
    scroll($('.media-list'));

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
                url: '{{$url}}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    '_token': token,
                    'message': msg,
                    'id': '{{$id}}',
                },
                success: function (data) {
                    $("#message-content").val('');
                    $(".ytb-wrapper").append(data['list_media']);
                    scroll($('.media-list'));
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

    socket.on("message:{{$type}}:{{$id}}", function (data) {
        $(".message-content").append(data.content);
    });


    players = new Array();
    var statusCurrent;
    var isNewSocket = 0;
    var timeChange = null;
    var isFromSocket = false;

    function onYouTubeIframeAPIReady() {
        var temp = $(".ytb-list iframe.yt_players");
        for (var i = 0; i < temp.length; i++) {
            var t = new YT.Player($(temp[i]).attr('id'), {
                events: {
                    'onStateChange': onPlayerStateChange,
                    'onReady': ready
                }
            });
            players.push(t);
        }
    }

    function ready(event) {
        if (statusCurrent != null && isNewSocket == 1) {
            if (statusCurrent[event.target.a.src]['currentTime'] > 0) {
                event.target.seekTo(statusCurrent[event.target.a.src]['currentTime']);
                if (statusCurrent[event.target.a.src]['state'] == YT.PlayerState.PLAYING) {
                    event.targer.playVideo();
                }
                else
                    event.target.pauseVideo();
            }
        }
    }

    function onPlayerStateChange(event) {

        if (isFromSocket == true) {
            return;
        }
        else if (event.data == YT.PlayerState.PLAYING) {
            var src = event.target.a.src;
            var order = play(src);
            var currentTime = event.target.getCurrentTime();
            socket.emit('YTBplay', order, currentTime);
        }
        else if (event.data == YT.PlayerState.PAUSED) {
            var src = event.target.a.src;
            var order = pause(src);
            socket.emit('YTBpause', order);
        }
    }

    function pause(src) {
        var order;
        var tempPlayers = $("iframe.yt_players");
        for (var i = 0; i < players.length; i++) {
            if (players[i].a.src == src) {
                players[i].pauseVideo();
                order = i;
                isFromSocket = false;
                return order;
            }
        }
    }

    function play(src) {

        var order;
        var tempPlayers = $("iframe.yt_players");
        for (var i = 0; i < players.length; i++) {
            if (players[i].a.src != src) {
                players[i].pauseVideo();
            } else {
                order = i;
            }
        }
        isFromSocket = false;
        return order;
    }

    socket.emit('YTBnewSocket','YTB');
    socket.on('YTBgetCurrentTime', function () {
        var data = {};
        var state = currentTime = null;
        for (var i = 0; i < players.length; i++) {
            state = players[i].getPlayerState();
            currentTime = players[i].getCurrentTime();
            var src = players[i].a.src;
            data[src] = {
                'currentTime': currentTime,
                'state': state,
            }
        }
        socket.emit('YTBgetCurrentTime', JSON.stringify(data));
    });

    socket.on('YTBsetCurrentTime', function (data) {
        statusCurrent = JSON.parse(data);
        isNewSocket = 1;
    })


    socket.on('YTBplay', function (order, currentTime) {
        isFromSocket = true;
        players[order].seekTo(currentTime);
        players[order].playVideo();
        play(players[order].a.src);
    });


    socket.on('YTBpause', function (order) {
        isFromSocket = true;
        pause(players[order].a.src);
    });
</script>