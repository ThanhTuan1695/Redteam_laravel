@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
@section('name-conv')
    <div class="name-conv" style="margin-bottom:20px">
        <h3 style="display:inline"><span>@</span>
            <a href="{{ route('viewDetail', $id) }}">
                {!! $get_room->name !!}
            </a>
        </h3>
        <a href="{{ route('outRoom', $id) }}" style="float:right" class="btn btn-default">Out Room</a>
        @if(Auth::user()->id==$get_room->user_id)
            <button style="float:right" type="submit" class="btn btn-default">
                <a href="{{ route('chooseUser', $id) }}">Add Member</a>
            </button>
        @endif
    </div>
@endsection
@section('list_users_tab')
    <li><a data-toggle="tab" href="#list_users">List Users</a></li>
@endsection
@section('list_users')
    <div class="form-group col-sm-12 tab-pane fade" id='list_users' style="margin:10px">
        {{--<a style="float:right" href="{!! route('callback', $id) !!}" class="btn btn-default">Back</a>--}}
        <div class="" style="height:90%;overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
            <table class="table table-responsive" id="users-table">
                <thead>
                <th>Username</th>
                <th>Action</th>
                </thead>
                <tbody>
                @foreach($listUsers as $listUser)
                    <tr>
                        <td>
                            <a href="{!! route('chatUser',$listUser->id) !!}">
                                <span>
                                    {{ $listUser->username }}
                                    @if($listUser->role == '1')
                                        (Admin)
                                    @endif
                                </span>
                            </a>
                        </td>
                        <td style="width: 80px;">
                            <div class='btn-group'>
                                @if((Auth::user()->id==$get_room->user_id) && (Auth::user()->id != $listUser->id))
                                    <a href="{{ route('delUserRoom',[$id,$listUser->id]) }}"
                                       class='btn btn-default btn-xs'>
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@include('frontend.layouts.content.content')
@section('scripts')
    @include('frontend.layouts.script.message')
@endsection
@endsection

