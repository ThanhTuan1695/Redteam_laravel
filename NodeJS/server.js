var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');
var socketIdList = new Array;
var listChannel = new Array;
server.listen(8890);

var ytb = io
    .of('/ytb')
    .on('connection', function (socket) {
        console.log('ytb connected');

        socket.on('newSocket', function (channel) {
            if (socketIdList[channel] == undefined) socketIdList[channel] = [];
            socketIdList[channel].splice(0, 0, socket.id);
            console.log(socketIdList);
            if (socketIdList[channel].length > 1) {
                var lateSocketId = socketIdList[channel][socketIdList[channel].length - 1];
                io.to(lateSocketId).emit(channel + 'YTBgetCurrentTime');
            }

        })

        socket.on('YTBgetCurrentTime', function (channel, data) {
            io.to(socketIdList[channel][0]).emit(channel + 'YTBsetCurrentTime', data);
        });

        socket.on('YTBpause', function (channel, data) {
            socket.broadcast.emit(channel + 'YTBpause', data);
        });


        socket.on('YTBplay', function (channel, order, currentTime) {
            socket.broadcast.emit(channel + 'YTBplay', order, currentTime);
        });

        socket.on('disconnect', function () {
            for (var item in socketIdList) {
                if (socketIdList[item].indexOf(socket.id) >= 0) {
                    var index = socketIdList[item].indexOf(socket.id);
                    socketIdList[item].splice(index, 1);
                    console.log('ytb  disconnect')
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
            if (socketIdList[channel] == undefined) socketIdList[channel] = [];
            socketIdList[channel].splice(0, 0, socket.id);
            console.log(socketIdList);
            if (socketIdList[channel].length > 1) {
                var lateSocketId = socketIdList[channel][socketIdList[channel].length - 1];
                io.to(lateSocketId).emit(channel + 'MSgetCurrentTime');
            }
        })

        socket.on('MSgetCurrentTime', function (channel, data) {
            io.to(socketIdList[0]).emit(channel + 'MSsetCurrentTime', data);
        });

        socket.on('MSplay', function (channel, audioName) {
            console.log('server');

            socket.broadcast.emit(channel + 'MSplay', audioName);
        });

        socket.on('MSpause', function (channel, audioName) {
            socket.broadcast.emit(channel + 'MSpause', audioName);
        });


        socket.on('MSchange', function (channel, data, audioName) {
            socket.broadcast.emit(channel + 'MSchange', data, audioName);
        });
        socket.on('disconnect', function () {
            for (var item in socketIdList) {
                if (socketIdList[item].indexOf(socket.id) >= 0) {
                    var index = socketIdList[item].indexOf(socket.id);
                    socketIdList[item].splice(index, 1);
                    console.log('music  disconnect')
                    break;
                }
            }
        })

    });

var msg = io
    .of('/msg')
    .on('connection', function (socket) {
        console.log("msg connected");
        var redisClient = redis.createClient();
        redisClient.subscribe('message');
        redisClient.on("message", function (channel, data) {
            console.log("mew message in queue " + data + "channel");
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

var video = io
    .of('/video')
    .on('connection', function (socket) {
        console.log('video connected');

        socket.on('newSocket', function (channel) {
            if (socketIdList[channel] == undefined) socketIdList[channel] = [];
            socketIdList[channel].splice(0, 0, socket.id);
            console.log(socketIdList);
            if (socketIdList[channel].length > 1) {
                var lateSocketId = socketIdList[channel][socketIdList[channel].length - 1];
                io.to(lateSocketId).emit(channel + 'VgetCurrentTime');
            }

        })
        socket.on('disconnect', function () {
            for (var item in socketIdList) {
                if (socketIdList[item].indexOf(socket.id) >= 0) {
                    var index = socketIdList[item].indexOf(socket.id);
                    socketIdList[item].splice(index, 1);
                    console.log('video disconnect')
                    break;
                }
            }
        })
    });

