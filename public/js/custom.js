
var socket_general = io.connect('http://localhost:8890/general');
var channel = $('.media').attr('title');
var input = $('#love-mes-form').find("input[type=text]");


$('#love-mes-form').on('submit', function (e) {
    var text = input.val();

    getTextAnimation(text);
    e.preventDefault();
    socket_general.emit('text', channel, text);
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

socket_general.on(channel+'text', function (text) {
    getTextAnimation(text);
});


$('.drop').droppable({
    tolerance: 'fit'
});

$('.drag').draggable({
    // revert: 'invalid', 
    helper: 'clone',

    // drag: function(e, ui){
    //           // var offset = $(this).offset();
    //           // var xPos = offset.left;
    //           // var yPos = offset.top;          
    //           console.log(ui.offset.left + " " + ui.offset.top);
    //            leftPosition  = ui.offset.left - $(this).offset().left;
    // 	topPosition   = ui.offset.top - $(this).offset().top;
    //           console.log(ui.position.left + " " + ui.position.top);
    //       },
    stop: function(event, ui ){
        $(this).draggable('option','revert','invalid');

    }
});

$('.drag').droppable({
    greedy: true,
    tolerance: 'touch',
    drop: function(event,ui){
        ui.draggable.draggable('option','revert',true);

    }
});


$('.drop').droppable({
    // accept: ".drag",

    drop: function(event,ui){
        // console.log(ui.position.left + " " + ui.position.top);
        if ($(ui.draggable)[0].id != "") {
            x = ui.helper.clone();
            ui.helper.remove();
            console.log(1);
            // x.attr('id',"bla");
            x.draggable({
                helper: 'original',
                containment: '.drop',
            });

            x.appendTo('.drop');
        }
        var content = "";
        for(var i = 0; i<$('.drop>.drag').length; i++){
            content+=$('.drop>.drag')[i].outerHTML;
        }
        socket_general.emit('sticker',channel,content);
    },

});

socket_general.on(channel+'sticker', function (content) {
    console.log(content);
    $('.drop>.drag').remove();
    $('.drop').append(content);
    $('.drop>.drag').draggable();


});

// function trigger_drop(x,y) {
//     var draggable = $(".drag").draggable();
//     dx = $('.drop').offset().left + x;
//     dy = $('.drop').offset().top + y;
//
//
//     draggable.simulate("drag", {
//         dx: x,
//         dy: y
//     });
// }