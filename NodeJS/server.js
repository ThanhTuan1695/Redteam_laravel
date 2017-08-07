var app = require('express')();
var server = require('https').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');
var socketIdList = new Array;
var listChannel = new Array;
server.listen();

io.on('connection', function (socket) {
    socket.on('newSocketConnect', function (channel) {
        io.of('/ytb').to('/ytb#' + socket.id).emit('test');
        if (socketIdList[channel] == undefined) socketIdList[channel] = [];
        socketIdList[channel].splice(0, 0, socket.id);
        console.log(socketIdList);
    })
    socket.on('refresh media', function (channel) {
        io.of('/ytb').to('/ytb#' + socket.id).emit(channel+'refresh media');
        io.of('/music').to('/music#' + socket.id).emit(channel+'refresh media');
        io.of('/video').to('/video#' + socket.id).emit(channel+ 'refresh media');
    })
    socket.on('disconnect', function () {
        for (var item in socketIdList) {
            if (socketIdList[item].indexOf(socket.id) >= 0) {
                var index = socketIdList[item].indexOf(socket.id);
                socketIdList[item].splice(index, 1);
                console.log('disconnect')
                break;
            }
        }
    })

});

var ytb = io
    .of('/ytb')
    .on('connection', function (socket) {
        console.log('ytb connected');

        socket.on('newSocket', function (channel) {
            if (socketIdList[channel] != undefined) {
                if (socketIdList[channel].length > 1) {
                    var lateSocketId = socketIdList[channel][socketIdList[channel].length - 1];
                    io.of('/ytb').to('/ytb#' + lateSocketId).emit(channel + 'YTBgetCurrentTime');
                }
            }


        })
        socket.on('YTBgetCurrentTime', function (channel, data) {
            io.of('/ytb').to('/ytb#' + socketIdList[channel][0]).emit(channel + 'YTBsetCurrentTime', data);
        });

        socket.on('YTBpause', function (channel, data) {
            console.log('pause');

            socket.broadcast.emit(channel + 'YTBpause', data);
        });

        socket.on('YTBplay', function (channel, order, currentTime) {
            console.log('play');
            socket.broadcast.emit(channel + 'YTBplay', order, currentTime);
        });


    });


var msg = io
    .of('/msg')
    .on('connection', function (socket) {
        console.log("msg connected");
        var redisClient = redis.createClient();
        redisClient.subscribe('message');
        redisClient.on("message", function (channel, data) {
            data = JSON.parse(data);
            socket.emit(channel + ":" + data.messagesType + ":" + data.idChannel, data);
        });
        socket.on('disconnect', function () {
            for (var item in socketIdList) {
                if (socketIdList[item].indexOf(socket.id) >= 0) {
                    var index = socketIdList[item].indexOf(socket.id);
                    socketIdList[item].splice(index, 1);
                    console.log('msg  disconnect')
                    break;
                }
            }
        })
    });
var music = io
    .of('/music')
    .on('connection', function (socket) {
        console.log('music connected');

        socket.on('newSocket', function (channel) {
            if (socketIdList[channel] != undefined) {
                if (socketIdList[channel].length > 1) {
                    var lateSocketId = socketIdList[channel][socketIdList[channel].length - 1];
                    io.of('/music').to('/music#' + lateSocketId).emit(channel + 'MSgetCurrentTime');
                }
            }

        })

        socket.on('MSgetCurrentTime', function (channel, data) {
            io.of('/music').to('/music#' + socketIdList[channel][0]).emit(channel + 'MSsetCurrentTime', data);
        });

        socket.on('MSplay', function (channel, audioName) {
            socket.broadcast.emit(channel + 'MSplay', audioName);
        });

        socket.on('MSpause', function (channel, audioName) {
            socket.broadcast.emit(channel + 'MSpause', audioName);
        });

        socket.on('heart', function (channel) {
            socket.broadcast.emit(channel + 'heart');
        })
        socket.on('MSchange', function (channel, data, audioName) {
            socket.broadcast.emit(channel + 'MSchange', data, audioName);
        });
    });

var video = io
    .of('/video')
    .on('connection', function (socket) {
        console.log('video connected');

        socket.on('newSocket', function (channel) {

            if (socketIdList[channel] != undefined) {
                if (socketIdList[channel].length > 1) {
                    var lateSocketId = socketIdList[channel][socketIdList[channel].length - 1];
                    io.of('/video').to('/video#' + lateSocketId).emit(channel + 'video_getCurrentTime');
                }
            }
        })

        socket.on('video_getCurrentTime', function (channel, data) {
            io.of('/video').to('/video#' + socketIdList[channel][0]).emit(channel + 'video_setCurrentTime', data);
        });

        socket.on('video_play', function (channel, id) {
            socket.broadcast.emit(channel + 'video_play', id);
        });
        socket.on('video_pause', function (channel, id) {
            socket.broadcast.emit(channel + 'video_pause', id);
        });
        socket.on('video_seek', function (channel, x, videoId) {
            socket.broadcast.emit(channel + 'video_seek', x, videoId);
        });


    });

var general = io
    .of('/general')
    .on('connection', function (socket) {
        console.log("general connected");
        socket.on('newSocket', function (channel) {

            if (socketIdList[channel] != undefined) {
                if (socketIdList[channel].length > 1) {
                    var lateSocketId = socketIdList[channel][socketIdList[channel].length - 1];
                    io.of('/general').to('/general#' + lateSocketId).emit(channel + 'sticker_getCurrent');
                }
            }
        })

        socket.on('sticker_getCurrent', function (channel, data) {
            console.log(data);
            io.of('/general').to('/general#' + socketIdList[channel][0]).emit(channel + 'sticker_setCurrent', data);
        });

        socket.on('text', function (channel, text) {
            socket.broadcast.emit(channel + 'text', text);
        });

        socket.on('sticker', function (channel, content) {
            socket.broadcast.emit(channel + 'sticker', content);
        });
    });
