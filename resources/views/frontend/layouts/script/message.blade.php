<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
<script src="http://www.youtube.com/player_api"></script>

<script type="text/javascript">
    var socket_msg = io.connect('http://localhost:8890/msg');
    var socket_connect = io.connect('http://localhost:8890/');
    var channel = $('.media').attr('title');
    socket_connect.emit('newSocketConnect', channel);

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
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        if (msg != '') {
            formdata.append('id', '{{$id}}');
            formdata.append('message', msg);
            $.ajax({
                type: "POST",
                url: '{{$url}}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formdata,
                success: function (data) {
                    $("#message-content").val('');
                    $('.fileinput-remove ').trigger('click');

                },
                error: function (data) {
                    console.log(1);
                    alert(data);
                },
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false,
            });
            return false;
        } else {
            alert("Please Add Message.");
            return false;
        }
    });
    socket_msg.on("message:{{$type}}:{{$id}}", function (data) {
        function notifyBrowser(title, desc, url) {
            if (!Notification) {
                console.log('Desktop notifications not available in your browser..');
                return;
            }
            if (Notification.permission !== "granted") {
                Notification.requestPermission();
            }
            else {
                var notification = new Notification(title, {
                    body: desc,
                });
                // Remove the notification from Notification Center when clicked.
                notification.onclick = function () {
                    //window.location = ("url");
                    window.location.href = this.tag;
                };
                notification.onclose = function () {
                    console.log('Notification closed');
                };
            }
        }

        if (data.sender_id == '{{$receiver_id}}') {
            // var url ="/single/"+ data.sender_id;
            notifyBrowser(data.usernameSender, data.content_notice);
        }
        $(".message-content").append(data.content);
        $(".ytb-wrapper").append(data.list_media_ytb);
        $(".video-wrapper").append(data.list_media_video);
        $(".music-wrapper").append(data.list_media_mp3);
    });
    var socket_ytb = io.connect('http://localhost:8890/ytb');
    socket_ytb.emit('newSocket', channel);
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
            socket_ytb.emit('YTBplay', '{{$type}}' + '{{$id}}', order, currentTime);
        }
        else if (event.data == YT.PlayerState.PAUSED) {
            var src = event.target.a.src;
            var order = pause(src);
            socket_ytb.emit('YTBpause', '{{$type}}' + '{{$id}}', order);
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

    socket_ytb.on('{{$type}}' + '{{$id}}' + 'YTBgetCurrentTime', function () {
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
        socket_ytb.emit('YTBgetCurrentTime', '{{$type}}' + '{{$id}}', JSON.stringify(data));
    });

    socket_ytb.on('{{$type}}' + '{{$id}}' + 'YTBsetCurrentTime', function (data) {
        statusCurrent = JSON.parse(data);
        isNewSocket = 1;
    })
    socket_ytb.on('{{$type}}' + '{{$id}}' + 'YTBplay', function (order, currentTime) {
        isFromSocket = true;
        players[order].seekTo(currentTime);
        players[order].playVideo();
        play(players[order].a.src);
    });
    socket_ytb.on('{{$type}}' + '{{$id}}' + 'YTBpause', function (order) {
        isFromSocket = true;
        pause(players[order].a.src);

    });
    $(function () {
        $('#message-content').change(function () {
            var content = $(this).val();
            $.ajax({
                url: '/previewUrl',
                type: 'GET',
                data: {
                    content: content,
                },
                success: function (response) {
                    console.log(response.success);
                    if (response.success) {
                        var data = response.data;
                        var preview = '<div class="row" data-miss>'
                                + '<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'
                                + '<div class="col-md-3">'
                                + '<div style="background: #999;">'
                                + '<img src="' + data.image + '" width="150" height="auto">'
                                + '</div>'
                                + '</div>'
                                + '<div class="col-md-9">'
                                + '<div class="row url-title">'
                                + '<a href="' + data.url + '">' + data.title + '</a>'
                                + '</div>'
                                + '<div class="row url-link">'
                                + '<a href="' + data.url + '">' + data.host + '</a>'
                                + '</div>'
                                + '<div class="row url-description">' + data.description + '</div>'
                                + '</div>'
                                + '</div>';
                        $('.file-preview .row').remove();
                        $('div.file-preview').addClass('alert alert-success alert-dismissable');
                        $('.file-preview').append(preview);
                    } else {
                        $('.file-preview-frame .row').remove();
                    }
                }
            });
        });
    });
</script>