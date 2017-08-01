
var socket_text = io.connect('http://localhost:8890/general');
var channel = $('.media').attr('title');
var input = $('#love-mes-form').find("input[type=text]");


$('#love-mes-form').on('submit', function (e) {
    var text = input.val();

    getTextAnimation(text);
    e.preventDefault();
    socket_text.emit('text', channel, text);
});

function getTextAnimation(text){
    var array_text = text.split(" ");
    var length = array_text.length;
    if (length % 3 != 0)
        length = length + (3 - length % 3);
    var one  = "<span class='ani-title'>";
    var two = one;
    var three = one ;
    var content = "<section class='ani-container' hidden><h1>";
    for (var i = 0; i < length / 3; i++) {
        one = one + array_text[i] + " ";
    }
    one += "</span></br>";

    for (var i = length / 3; i < length * 2 / 3; i++) {
        if(array_text[i] == undefined) break;
        two = two + array_text[i] + " ";
    }
    two += "</span></br>";

    for (var i = 2 * length / 3; i < length; i++) {
        if(array_text[i] == undefined) break;
        three = three + array_text[i] + " ";
    }
    three += "</span>";
    var end = "</h1></section>";
    if(one != undefined) content+=one;
    if(two != undefined) content+=two;
    if(three != undefined) content+=three;
    content+=end;
    $('.name-media-list').append(content);
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

socket_text.on(channel+'text', function (text) {
    getTextAnimation(text);
});