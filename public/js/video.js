/*
 JS Modified from a tutorial found here: 
 http://www.inwebson.com/html5/custom-html5-video-controls-with-jquery/

 I really wanted to learn how to skin html5 video.
 */
$(document).ready(function(){
    //INITIALIZE
    var socket_video = io.connect('http://localhost:8890/video');
    var videos = new Array();
    var listVideo = $('.videoContainer');
    for(var i = 0 ; i < listVideo.length; i++){
        var id = $(listVideo[i]).attr('id');
        var video = $('#'+id+' #playerVideo');

        video[0].removeAttribute("controls");
        $('.control').fadeIn(500);
        $('.caption').fadeIn(500);

        //before everything get started
        (function(id,video){
            video.on('loadedmetadata', function() {
                //set video properties
                $('#'+id+' .current').text(timeFormat(0));
                $('#'+id+' .duration').text(timeFormat(video[0].duration));

                //start to get video buffering data 
                setTimeout(function(){
                    startBuffer(id);
                }, 150);

                //bind video events
                $('#'+id)
                    .hover(function() {
                        $('#'+id+' .control').stop().fadeIn();
                        $('#'+id+' .caption').stop().fadeIn();
                    }, function() {
                        if(!volumeDrag && !timeDrag){
                            $('#'+id+' .control').stop().fadeOut();
                            $('#'+id+' .caption').stop().fadeOut();
                        }
                    })
                    .on('click', function() {
                        $('#'+id+' .btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');
                        $(this).unbind('click');
                        video[0].play();
                    });
            });
        })(id,video);
        videos[id] = video;
    }
    //remove default control when JS loaded


    //display video buffering bar
    var startBuffer = function(id) {
        var currentBuffer = videos[id][0].buffered.end(0);
        var maxduration = videos[id][0].duration;
        var perc = 100 * currentBuffer / maxduration;
        $('#'+id+' .bufferBar').css('width',perc+'%');
        if(currentBuffer < maxduration) {
            setTimeout(function(){
                startBuffer(id);
            }, 500);		}
    };

    for(var i = 0 ; i < listVideo.length; i++){
        var id = $(listVideo[i]).attr('id');
        video = videos[id];
        (function(id,video){
            //display current video play time
            video.on('timeupdate', function() {
                var currentPos = video[0].currentTime;
                var maxduration = video[0].duration;
                var perc = 100 * currentPos / maxduration;
                $('#'+id+' .timeBar').css('width',perc+'%');
                $('#'+id+' .current').text(timeFormat(currentPos));
            });

            //CONTROLS EVENTS
            //video screen and play button clicked
            video.on('click', function() {
                playpause(id);
            } );
            //VIDEO EVENTS
            //video canplay event
            video.on('canplay', function() {
                $('#'+id+' .loading').fadeOut(100);
            });

            //video canplaythrough event
            //solve Chrome cache issue
            var completeloaded = false;
            video.on('canplaythrough', function() {
                completeloaded = true;
            });

            //video ended event
            video.on('ended', function() {
                $('#'+id+' .btnPlay').removeClass('paused');
                video[0].pause();
            });

            //video seeking event
            video.on('seeking', function() {
                //if video fully loaded, ignore loading screen
                if(!completeloaded) {
                    $('#'+id+' .loading').fadeIn(200);
                }
            });

            //video seeked event
            video.on('seeked', function() {
            });

            //video waiting for more data event
            video.on('waiting', function() {
                $('#'+id+' .loading').fadeIn(200);
            });
        })(id,video);
    }

    $('.btnPlay').on('click', function(e) {
        playpause(getIdVideo(e));
    });

    var playpause = function(id) {
        var video = videos[id];
        if(video[0].paused || video[0].ended) { //stop
            socket_video.emit('play', id);
            playing(id);
        }
        else { //playing
            socket_video.emit('pause', id);
            paused(id);
        }
    };

    var playing = function(id){
        var video = videos[id];
        for(var i = 0 ; i < listVideo.length; i++){
            var videoId = $(listVideo[i]).attr('id');
            if(id != videoId){
                $('#'+videoId+' .btnPlay').removeClass('paused');
                $('#'+videoId+' .btnPlay').find('.icon-pause').removeClass('icon-pause').addClass('icon-play');
                videos[videoId][0].pause();
            }
            else {
                $('#'+id+' .btnPlay').addClass('paused');
                $('#'+id+' .btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');
                video[0].play();
            }
        }
    };

    var paused = function(id){
        var video = videos[id];
        $('#'+id+' .btnPlay').removeClass('paused');
        $('#'+id+' .btnPlay').find('.icon-pause').removeClass('icon-pause').addClass('icon-play');
        video[0].pause();
    };

    //fullscreen button clicked
    $('.btnFS').on('click', function(e) {
        var videoId = getIdVideo(e);
        var video = videos[videoId];
        if($.isFunction(video[0].webkitEnterFullscreen)) {
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
    $('.sound').click(function(e) {
        var videoId = getIdVideo(e);
        var video = videos[videoId];
        video[0].muted = !video[0].muted;
        $('#'+videoId+' .sound').toggleClass('muted');
        if(video[0].muted) {
            $('#'+videoId+' .volumeBar').css('width',0);
        }
        else{
            $('#'+videoId+' .volumeBar').css('width', video[0].volume*100+'%');
        }
    });



    //VIDEO PROGRESS BAR
    //when video timebar clicked
    var timeDrag = false;	/* check for drag event */
    $('.progressTime').on('mousedown', function(e) {
        timeDrag = true;
        var videoId = getIdVideo(e);
        var percentage = getPercentOfTime(e.pageX, videoId);
        socket_video.emit('seek',percentage, videoId );
        updatebar(percentage, videoId);
    });
    $(document).on('mouseup', function(e) {
        if(timeDrag) {
            timeDrag = false;
            var videoId = getIdVideo(e);
            var percentage = getPercentOfTime(e.pageX, videoId);
            socket_video.emit('seek',percentage, videoId );
            updatebar(percentage, videoId);
        }
    });
    var updatebar = function(percentage, videoId) {
        var video = videos[videoId];
        //calculate drag position
        //and update video currenttime
        //as well as progress bar
        var maxduration = video[0].duration;
        if(percentage > 100) {
            percentage = 100;
        }
        if(percentage < 0) {
            percentage = 0;
        }
        $('#'+videoId+' .timeBar').css('width',percentage+'%');
        video[0].currentTime = maxduration * percentage / 100;
    };

    function getPercentOfTime(x, videoId){
        var video = videos[videoId];
        var progress = $('#'+videoId+' .progressTime');
        var position = x - progress.offset().left;
        var percentage = 100 * position / progress.width();
        return percentage;
    }
    //VOLUME BAR
    //volume bar event
    var volumeDrag = false;
    $('.volume').on('mousedown', function(e) {
        var videoId = getIdVideo(e);
        var video = videos[videoId];
        volumeDrag = true;
        video[0].muted = false;
        $('#'+videoId+' .sound').removeClass('muted');
        updateVolume(e.pageX, videoId);
    });
    $(document).on('mouseup', function(e) {
        var videoId = getIdVideo(e);
        if(volumeDrag) {
            volumeDrag = false;
            updateVolume(e.pageX, videoId);
        }
    });
    $(document).on('mousemove', function(e) {
        var videoId = getIdVideo(e);
        if(volumeDrag) {
            updateVolume(e.pageX, videoId);
        }
    });
    var updateVolume = function(x,  videoId) {
        var video = videos[videoId];
        var volume = $('#'+videoId+' .volume');
        var percentage;
        //if only volume have specificed
        //then direct update volume


        var position = x - volume.offset().left;
        percentage = 100 * position / volume.width();

        if(percentage > 100) {
            percentage = 100;
        }
        if(percentage < 0) {
            percentage = 0;
        }

        //update volume bar and video volume
        $('#'+videoId+' .volumeBar').css('width',percentage+'%');
        video[0].volume = percentage / 100;

        //change sound icon based on volume
        if(video[0].volume == 0){
            $('#'+videoId+' .sound').removeClass('sound2').addClass('muted');
        }
        else if(video[0].volume > 0.5){
            $('#'+videoId+' .sound').removeClass('muted').addClass('sound2');
        }
        else{
            $('#'+videoId+' .sound').removeClass('muted').removeClass('sound2');
        }

    };

    //Time format converter - 00:00
    var timeFormat = function(seconds){
        var m = Math.floor(seconds/60)<10 ? "0"+Math.floor(seconds/60) : Math.floor(seconds/60);
        var s = Math.floor(seconds-(m*60))<10 ? "0"+Math.floor(seconds-(m*60)) : Math.floor(seconds-(m*60));
        return m+":"+s;
    };

    function getIdVideo(e){
        return $(e.target).parentsUntil('.videoContainer').closest('.videoContainer').attr('id');
    }
    function getVideoState(videoId){
        if(!videos[videoId][0].paused) return 'play';
        else return 'pause';
    }
    socket_video.on('getCurrentTime', function(){
        var data = {};
        for( var i = 0 ; i < listVideo.length; i++){
            var videoId = $(listVideo[i]).attr('id');
            var currentTime = parseInt(videos[videoId][0].currentTime, 10);
            var status  =  getVideoState(videoId);
            data[videoId] = {
                'currentTime' : currentTime,
                'status' : status,
            };
        }
        console.log(data);
        socket_video.emit('getCurrentTime',JSON.stringify(data));
    });

    socket_video.on('setCurrentTime', function(data){
        var data = JSON.parse(data);
        for( var i = 0 ; i < listVideo.length; i++){
            var videoId = $(listVideo[i]).attr('id');
            videos[videoId][0].currentTime = parseInt(data[videoId].currentTime, 10);
            var status  =  data[videoId].status;
            if( status == 'play') {
                videos[videoId][0].play();
                $('#'+videoId+' .btnPlay').addClass('paused');
                $('#'+videoId+' .btnPlay').find('.icon-play').addClass('icon-pause').removeClass('icon-play');			}
            else{
                videos[videoId][0].pause();
            }

        }
    })
    socket_video.on('play',function(videoId){
        playing(videoId);
    });
    socket_video.on('pause',function(videoId){
        paused(videoId);
    });
    socket_video.on('seek',function(x, videoId){
        $('#'+videoId+' .control').stop().fadeIn();
        $('#'+videoId+' .caption').stop().fadeIn();
        updatebar(x, videoId);
        $('#'+videoId+' .control').stop().fadeOut();
        $('#'+videoId+' .caption').stop().fadeOut();
    });

});