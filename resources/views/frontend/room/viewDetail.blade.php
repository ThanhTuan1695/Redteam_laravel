@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <div class="form-group col-sm-12" style="margin:10px">  
        <a style="float:right" href="{!! route('callback', $id) !!}" class="btn btn-default">Back</a>
        <div class="col-lg-3" style="height:90%;overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
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
                                    <a href="{{ route('delUserRoom',[$id,$listUser->id]) }}" class='btn btn-default btn-xs'>
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

