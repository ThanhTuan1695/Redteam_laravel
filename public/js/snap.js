$(document).ready(function () {
        function makeid() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 9; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    $('#attach').click(function () {
        if ($(this).hasClass('attach')) {
            Webcam.attach('#my_camera');
            $(this).val('Stop Webcam');
            $(this).removeClass('attach');
            $(this).addClass('detach');
        }
        else {
            Webcam.reset('#my_camera');
            $(this).val('Start Webcam');
            $(this).removeClass('detach');
            $(this).addClass('attach');

        }

    });

    var data_uri;
    $('#snap').click(function (e) {
        Webcam.snap(function (data_uri) {
            data_uri = data_uri;
            var left = Math.floor(Math.random() * 300) + 15;
            var top = Math.floor(Math.random() * 300) + 15;
            var name = makeid();
            console.log(send_snap + name);

            Webcam.upload(data_uri, send_snap + name, function (code, text) {
                var content = "<div class='drag inside-drop-zone'  style=' position: absolute; left: " + left + "px; top: " + top + "px; width:80px'>" +
                    "<img class='sticker' id='st" + name + "' src='"+storage_sticker+"/" + name + ".jpg' style='width : 80px;' ></div>";
                $('.drop').append(content);
                $('.drop>.drag').draggable();
                socket_general.emit('sticker', channel, content);
            });
        });

        e.preventDefault();
    })



})