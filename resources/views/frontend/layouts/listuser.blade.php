@foreach($listUserPL as $listUserPL)
@if(Auth::user()->id != $listUserPL->id)
<li class="{{ Request::is('rooms*') ? 'active' : '' }}">
    <a href="{!! route('chatUser',$listUserPL->id) !!}"><i class="fa fa-user"></i>
        <span>
            {{ $listUserPL->username }}
            @if($listUserPL->role == '1')
                (Admin)
            @endif
        </span>
    </a>
</li>
@endif
@endforeach
