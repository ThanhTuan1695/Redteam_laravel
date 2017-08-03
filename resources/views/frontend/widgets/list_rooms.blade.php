@foreach($listRoomPL as $room)
    @if( $room->type == 'public')
    <li >
        <a href="{!! route('chatRoom',$room->id) !!}"><i class="fa fa-unlock"></i><span>{{ $room->name }}</span></a>
    </li>
    @else
        <li>
            <a href="{!! route('chatRoom',$room->id) !!}"><i class="fa fa-lock"></i><span>{{ $room->name }}</span></a>
        </li>
        @endif
@endforeach
