@foreach($listUserPL as $listUserPL)
<li class="{{ Request::is('rooms*') ? 'active' : '' }}">
    <a href=""><i class="fa fa-user"></i>
        <span>
            {{ $listUserPL->username }}
            @if($listUserPL->role == '1')
                (Admin)
            @endif
        </span>
    </a>
</li>
@endforeach
