$(document).ready(function () {
    var channel = $('.media').attr('title');
    var socket_video = io.connect(node_url+'/video');

    var videos = new Array();
    var volumeDrag = false;
    var timeDrag = false;
    var countReadyState = 0;
    var listVideo = $('.videoContainer');
    for (var i = 0; i < listVideo.length; i++) {
        var id = $(listVideo[i]).attr('id');
        var video = $('#' + id + ' #playerVideo');
        video[0].removeAttribute("controls");
        $('#' + id + ' .control').fadeIn(500);
        $('#' + id + ' .caption').fadeIn(500);
        //before everything get started
        (function (id, video) {
            if(video[0].readyState >=2 ){
                loaddata(id, video);
            }
            else {
                video[0].addEventListener('loadedmetadata', function () {
                    loaddata(id, video);
                });
            }

        })(id, video);
        videos[id] = video;
    }
    function loaddata(id, video) {
        $('#' + id + ' .current').text(timeFormat(0));
        $('#' + id + ' .duration').text(timeFormat(video[0].duration));
        $('#' + id)
            .hover(function () {
                $('#' + id + ' .control').stop().fadeIn();
                $('#' + id + ' .caption').stop().fadeIn();
            }, function () {
                if (!volumeDrag && !timeDrag) {
                    $('#' + id + ' .control').stop().fadeOut();
                    $('#' + id + ' .caption').stop().fadeOut();
                }
            })
            .on('click', function () {
                $('#' + id + ' .btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');
                $(this).unbind('click');
                video[0].play();
            });
    }

    socket_video.emit('newSocket', channel);

    for (var i = 0; i < listVideo.length; i++) {
        var id = $(listVideo[i]).attr('id');
        video = videos[id];

        (function (id, video) {
            //display current video play time
            video.on('timeupdate', function () {
                var currentPos = video[0].currentTime;
                var maxduration = video[0].duration;
                var perc = 100 * currentPos / maxduration;
                $('#' + id + ' .video-timeBar').css('width', perc + '%');
                $('#' + id + ' .current').text(timeFormat(currentPos));
            });

            //CONTROLS EVENTS
            //video screen and play button clicked
            video.on('click', function () {
                playpause(id);
            });
            //VIDEO EVENTS
            //video canplay event
            video.on('canplay', function () {
                $('#' + id + ' .loading').fadeOut(100);
            });

            //video canplaythrough event
            //solve Chrome cache issue
            var completeloaded = false;
            video.on('canplaythrough', function () {
                completeloaded = true;
            });

            //video ended event
            video.on('ended', function () {
                $('#' + id + ' .btnPlay').removeClass('paused');
                video[0].pause();
            });

            //video seeking event
            video.on('seeking', function () {
                //if video fully loaded, ignore loading screen
                if (!completeloaded) {
                    $('#' + id + ' .loading').fadeIn(200);
                }
            });

            //video seeked event
            video.on('seeked', function () {
            });

            //video waiting for more data event
            video.on('waiting', function () {
                $('#' + id + ' .loading').fadeIn(200);
            });
        })(id, video);
    }

    $('.btnPlay').on('click', function (e) {
        playpause(getIdVideo(e));
    });

    var playpause = function (id) {
        var video = videos[id];
        if (video[0].paused || video[0].ended) { //stop
            socket_video.emit('video_play', channel, id);
            playing(id);
        }
        else { //playing
            socket_video.emit('video_pause', channel, id);
            paused(id);
        }
    };

    var playing = function (id) {
        var video = videos[id];
        for (var i = 0; i < listVideo.length; i++) {
            var videoId = $(listVideo[i]).attr('id');
            if (id != videoId) {
                $('#' + videoId + ' .btnPlay').removeClass('paused');
                $('#' + videoId + ' .btnPlay').find('.icon-pause').removeClass('icon-pause').addClass('icon-play');
                videos[videoId][0].pause();
            }
            else {
                $('#' + id + ' .btnPlay').addClass('paused');
                $('#' + id + ' .btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');
                video[0].play();
            }
        }
    };

    var paused = function (id) {
        var video = videos[id];
        $('#' + id + ' .btnPlay').removeClass('paused');
        $('#' + id + ' .btnPlay').find('.icon-pause').removeClass('icon-pause').addClass('icon-play');
        video[0].pause();
    };

    //fullscreen button clicked
    $('.btnFS').on('click', function (e) {
        var videoId = getIdVideo(e);
        var video = videos[videoId];
        if ($.isFunction(video[0].webkitEnterFullscreen)) {
            video[0].webkitEnterFullscreen();
        }
        else if ($.isFunction(video[0].mozRequestFullScreen)) {
            video[0].mozRequestFullScreen();
        }
        else {
            alert('Your browsers doesn\'t support fullscreen');
        }
    });

    //sound button clicked
    $('.sound').click(function (e) {
        var videoId = getIdVideo(e);
        var video = videos[videoId];
        video[0].muted = !video[0].muted;
        $('#' + videoId + ' .sound').toggleClass('muted');
        if (video[0].muted) {
            $('#' + videoId + ' .volumeBar').css('width', 0);
        }
        else {
            $('#' + videoId + ' .volumeBar').css('width', video[0].volume * 100 + '%');
        }
    });


    //VIDEO PROGRESS BAR
    //when video video-timeBar clicked
    $('.progressTime').on('mousedown', function (e) {
        timeDrag = true;
        var videoId = getIdVideo(e);
        var percentage = getPercentOfTime(e.pageX, videoId);
        socket_video.emit('video_seek', channel, percentage, videoId);
        updatebar(percentage, videoId);
    });
    $(document).on('mouseup', function (e) {
        if (timeDrag) {
            timeDrag = false;
            var videoId = getIdVideo(e);
            var percentage = getPercentOfTime(e.pageX, videoId);
            socket_video.emit('video_seek', channel, percentage, videoId);
            updatebar(percentage, videoId);
        }
    });
    var updatebar = function (percentage, videoId) {
        var video = videos[videoId];
        //calculate drag position
        //and update video currenttime
        //as well as progress bar
        if (percentage > 100) {
            percentage = 100;
        }
        if (percentage < 0) {
            percentage = 0;
        }
        $('#' + videoId + ' .video-timeBar').css('width', percentage + '%');
        var maxduration = video[0].duration;
        video[0].currentTime = maxduration * percentage / 100;

    };

    function getPercentOfTime(x, videoId) {
        var video = videos[videoId];
        var progress = $('#' + videoId + ' .progressTime');
        var position = x - progress.offset().left;
        var percentage = 100 * position / progress.width();
        return percentage;
    }

    //VOLUME BAR
    //volume bar event
    $('.volume').on('mousedown', function (e) {
        var videoId = getIdVideo(e);
        var video = videos[videoId];
        volumeDrag = true;
        video[0].muted = false;
        $('#' + videoId + ' .sound').removeClass('muted');
        updateVolume(e.pageX, videoId);
    });
    $(document).on('mouseup', function (e) {
        var videoId = getIdVideo(e);
        if (volumeDrag) {
            volumeDrag = false;
            updateVolume(e.pageX, videoId);
        }
    });
    $(document).on('mousemove', function (e) {
        var videoId = getIdVideo(e);
        if (volumeDrag) {
            updateVolume(e.pageX, videoId);
        }
    });
    var updateVolume = function (x, videoId) {
        var video = videos[videoId];
        var volume = $('#' + videoId + ' .volume');
        var percentage;
        //if only volume have specificed
        //then direct update volume


        var position = x - volume.offset().left;
        percentage = 100 * position / volume.width();

        if (percentage > 100) {
            percentage = 100;
        }
        if (percentage < 0) {
            percentage = 0;
        }

        //update volume bar and video volume
        $('#' + videoId + ' .volumeBar').css('width', percentage + '%');
        video[0].volume = percentage / 100;

        //change sound icon based on volume
        if (video[0].volume == 0) {
            $('#' + videoId + ' .sound').removeClass('sound2').addClass('muted');
        }
        else if (video[0].volume > 0.5) {
            $('#' + videoId + ' .sound').removeClass('muted').addClass('sound2');
        }
        else {
            $('#' + videoId + ' .sound').removeClass('muted').removeClass('sound2');
        }

    };

    //Time format converter - 00:00
    function timeFormat(seconds) {
        var m = Math.floor(seconds / 60) < 10 ? "0" + Math.floor(seconds / 60) : Math.floor(seconds / 60);
        var s = Math.floor(seconds - (m * 60)) < 10 ? "0" + Math.floor(seconds - (m * 60)) : Math.floor(seconds - (m * 60));
        return m + ":" + s;
    };

    function getIdVideo(e) {
        return $(e.target).parentsUntil('.videoContainer').closest('.videoContainer').attr('id');
    }

    function getVideoState(videoId) {
        if (!videos[videoId][0].paused) return 'play';
        else return 'pause';
    }

    socket_video.on(channel + 'video_getCurrentTime', function () {
        var data = {};
        for (var i = 0; i < listVideo.length; i++) {
            var videoId = $(listVideo[i]).attr('id');
            var currentTime = parseInt(videos[videoId][0].currentTime, 10);

            var status = getVideoState(videoId);
            data[videoId] = {
                'currentTime': currentTime,
                'status': status,
                'duration': videos[videoId][0].duration,
            };
        }
        socket_video.emit('video_getCurrentTime', channel, JSON.stringify(data));
    });

    socket_video.on(channel + 'video_setCurrentTime', function (data) {
        var data = JSON.parse(data);
        for (var i = 0; i < listVideo.length; i++) {
            var videoId = $(listVideo[i]).attr('id');
            var per = data[videoId].currentTime * 100 / data[videoId].duration;
            videos[videoId][0].currentTime = data[videoId].currentTime * 100;
            $('#' + videoId + ' .control').stop().fadeIn();
            $('#' + videoId + ' .caption').stop().fadeIn();
            updatebar(per, videoId);
            $('#' + videoId + ' .control').stop().fadeOut();
            $('#' + videoId + ' .caption').stop().fadeOut();
            var status = data[videoId].status;
            if (status == 'play') {
                videos[videoId][0].play();
                $('#' + videoId + ' .btnPlay').addClass('paused');
                $('#' + videoId + ' .btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');
            }
            else {
                videos[videoId][0].pause();
            }

        }

        for (var i = 0; i < listVideo.length; i++) {
            var videoId = $(listVideo[i]).attr('id');
        }

    })
    socket_video.on(channel + 'video_play', function (videoId) {
        playing(videoId);
    });
    socket_video.on(channel + 'video_pause', function (videoId) {
        paused(videoId);
    });
    socket_video.on(channel + 'video_seek', function (x, videoId) {
        $('#' + videoId + ' .control').stop().fadeIn();
        $('#' + videoId + ' .caption').stop().fadeIn();
        updatebar(x, videoId);
        $('#' + videoId + ' .control').stop().fadeOut();
        $('#' + videoId + ' .caption').stop().fadeOut();
    });

});