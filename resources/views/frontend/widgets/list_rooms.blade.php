@foreach($listRoomPL as $listRoomPL)
    <li class="{{ Request::is('rooms*') ? 'active' : '' }}">
        <a href="{!! route('chatRoom',$listRoomPL->id) !!}"><i class="fa fa-line-chart"></i><span>{{ $listRoomPL->name }}</span></a>
    </li>
@endforeach
