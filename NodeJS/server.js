var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);
io.on('connection', function (socket) {

  console.log("new client connected");
  var redisClient = redis.createClient();

  redisClient.subscribe('message');

  redisClient.on("message", function(channel, message) {
    console.log("mew message in queue "+ message + "channel");
    data = JSON.parse(message);
    console.log(channel + ":" + data.messagesType+
     ":"+ data.idChannel);
    // socket.emit(channel, message);
    socket.emit(channel+ ":" + data.messagesType+
     ":"+ data.idChannel,data);

  });

  socket.on('disconnect', function() {
    redisClient.quit();
  });

});