var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');
var socketIdList = new Array;
socketIdList['YTB'] = [];
server.listen(8890);
io.on('connection', function (socket) {

    console.log("new client connected");
    var redisClient = redis.createClient();

    redisClient.subscribe('message');

    redisClient.on("message", function (channel, data) {
        console.log("mew message in queue " + data + "channel");
        data = JSON.parse(data);
        socket.emit(channel + ":" + data.messagesType + ":" + data.idChannel, data);
    });

    socket.on('YTBnewSocket', function (data) {
        if (data == 'YTB') {
            socketIdList[data].splice(0, 0, socket.id);
            if (socketIdList[data].length > 1) {
                var lateSocketId = socketIdList[data][socketIdList.length - 1];
                io.to(lateSocketId).emit('YTBgetCurrentTime');
            }
        }
    })

    socket.on('YTBgetCurrentTime', function (data) {
        io.to(socketIdList[data][0]).emit('YTBsetCurrentTime', data);
    });

    socket.on('YTBpause', function (data) {
        socket.broadcast.emit('YTBpause', data);
    });


    socket.on('YTBplay', function (order, currentTime) {
        socket.broadcast.emit('YTBplay', order, currentTime);
    });

    socket.on('disconnect', function () {
        var index = socketIdList.indexOf(socket.id);
        socketIdList.splice(index, 1);
        console.log('dissconnect');
    })


})