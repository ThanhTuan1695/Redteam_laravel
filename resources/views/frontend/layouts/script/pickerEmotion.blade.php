<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

<script src="{{ url('/css/lib/js/config.js')}}"></script>
<script src="{{ url('/css/lib/js/util.js') }}"></script>
<script src="{{ url('/css/lib/js/jquery.emojiarea.js') }}"></script>
<script src="{{ url('/css/lib/js/emoji-picker.jslib/js/util.js') }}"></script>

<script>
    $(function () {
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '{{url('/css/lib/img/')}}',
            popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
    });
</script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-49610253-3', 'auto');
    ga('send', 'pageview');
</script>