$(document).ready(function () {
    console.log(node_url);
    socket_general = io.connect(node_url+'/general');
    var channel = $('.media').attr('title');
    var input = $('#love-mes-form').find("input[type=text]");
    var customText = $('#custom-text').find("input[type=text]");
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    $('#love-mes-form').on('submit', function (e) {
        var text = input.val();
        getTextAnimation(text);
        socket_general.emit('text', channel, text);
        e.preventDefault();
    });
    $('#custom-text').on('submit', function (e) {
        var text = customText.val();
        text = "<div class='drag inside-drop-zone'  style=' position: absolute; left: 79.0001px; top: 215.2px;'><span class='custom-text-sticker sticker'>" + text + "</span></div>";
        $('.drop').append(text);
        var textSpan = $(".drop>.drag>span");
        var thisSpan = textSpan[textSpan.length - 1];
        $(thisSpan).lettering();
        $(thisSpan).css('color', getRandomColor());
        $('.drop>.drag').draggable();
        customText.val("");
        e.preventDefault();

    });

    function getTextAnimation(text) {
        var array_text = text.split(" ");
        var length = array_text.length;
        if (length % 3 != 0)
            length = length + (3 - length % 3);
        var one = "<span class='ani-title'>";
        var two = one;
        var three = one;
        var content = "<section class='ani-container' hidden><h1>";
        for (var i = 0; i < length / 3; i++) {
            one = one + array_text[i] + " ";
        }
        one += "</span></br>";
        for (var i = length / 3; i < length * 2 / 3; i++) {
            if (array_text[i] == undefined) break;
            two = two + array_text[i] + " ";
        }
        two += "</span></br>";
        for (var i = 2 * length / 3; i < length; i++) {
            if (array_text[i] == undefined) break;
            three = three + array_text[i] + " ";
        }
        three += "</span>";
        var end = "</h1></section>";
        if (one != undefined) content += one;
        if (two != undefined) content += two;
        if (three != undefined) content += three;
        content += end;
        $('.main-content').append(content);
        $(".ani-title").lettering();
        $(".ani-container").fadeIn();
        input.val("");
        animation();
        setTimeout(function () {
            $('.ani-container').remove();
        }, 3000);
    }

    function animation() {
        var title1 = new TimelineMax();
        title1.staggerFromTo(".ani-title span", 0.5,
            {ease: Back.easeOut.config(1.7), opacity: 0, bottom: -80},
            {ease: Back.easeOut.config(1.7), opacity: 1, bottom: 0}, 0.05);
    }

    socket_general.on(channel + 'text', function (text) {
        getTextAnimation(text);
    });

    socket_general.emit('newSocket', channel);


    $('.drop').droppable({
        tolerance: 'fit'
    });
    $('.drag').draggable({
        helper: 'clone',
    });
    $('.drag').droppable({
        greedy: true,
        tolerance: 'touch',
    });
    var content = "";

    $('.drop').droppable({

        accept: '.drag',
        drop: function(event, ui) {
            var $clone = ui.helper.clone();
            if (!$clone.is('.inside-drop-zone')) {
                $(this).append($clone.addClass('inside-drop-zone').draggable({
                    containment: '.drop'
                }));

                // $clone.resizable({ //this works but I dont want it to on outside elements
                //     helper: "ui-resizable-helper"
                // });
            }
            $('.drop>.drag>img').resizable({
                helper: "ui-resizable-helper"
            });
            content = "";
            for (var i = 0; i < $('.drop>.drag').length; i++) {
                content += $('.drop>.drag')[i].outerHTML;
            }
        },

    });

    $('.bin').droppable({
        drop: function (event, ui) {
            ui.helper.remove();
            content = "";
            for (var i = 0; i < $('.drop>.drag').length; i++) {
                content += $('.drop>.drag')[i].outerHTML;
            }
            socket_general.emit('sticker', channel, content);
        },

    });

    socket_general.on(channel + 'sticker_getCurrent', function () {
        socket_general.emit('sticker_getCurrent', channel, content);
    })
    socket_general.on(channel + 'sticker_setCurrent', function (data) {
        console.log(data);
        $('.drop').append(data);
        $('.drop>.drag').draggable();
    })
    socket_general.on(channel + 'sticker', function (content) {
        $('.drop>.drag').remove();
        $('.drop').append(content);
        $('.drop>.drag').draggable();
        rotation();
    });

    $('.sticker-play').click(function (e) {
        rotation();
        socket_general.emit('sticker', channel, content);

    })

    var rotation = function () {
        $(".drop .ui-wrapper>.sticker, .drop>.inside-drop-zone span").rotate({
            angle: -25,
            animateTo: 25,
            callback: back
        });
    }

    var back = function () {
        $(".drop>.inside-drop-zone .sticker, .drop>.inside-drop-zone span").rotate({
            angle: 25,
            animateTo: -25,
            callback: rotation
        });
    }
})