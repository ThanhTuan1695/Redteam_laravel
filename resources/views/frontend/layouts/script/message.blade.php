<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
<script type="text/javascript">
    $(function () {
        $("#all_messages").animate({
            scrollTop: $("#all_messages")[0].scrollHeight
        });

        $('.display-media ').on('click', function (e) {
            if ($('.media').hasClass('hidden')) {
                $('.media').removeClass('hidden').stop().fadeIn("slow");
                $('.content').removeClass('col-lg-12').addClass('flex').addClass('col-lg-7');
            }
            else {
                $('.media').addClass('hidden').stop().fadeOut("slow");
                $('.content').removeClass('col-lg-7').removeClass('flex').addClass('col-lg-12');
            }
        });

        $('#form-sub').on('submit', function (e) {
            var token = $("input[name='_token']").val();
            var msg = $("#message-content").val();
            if (msg != '') {
                $.ajax({
                    type: "POST",
                    url: '{{$url}}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        '_token': token,
                        'message': msg,
                        'id': '{{$id}}',
                    },
                    success: function (data) {
                        $("#message-content").val('');
                    },
                    error: function (data) {
                        console.log('error');
                    }
                });
                return false;
            } else {
                alert("Please Add Message.");
                return false;
            }
        });

        var socket = io.connect('http://localhost:8890');
        socket.on("message:{{$type}}:{{$id}}", function (data) {
            $(".message-content").append(data.content);
            console.log(1);
        });
    });
</script>