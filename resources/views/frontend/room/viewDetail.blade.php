@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <div class="form-group col-sm-12" style="margin:10px">  
        <a style="float:right" href="{!! route('callback', $id) !!}" class="btn btn-default">Back</a>
        <div class="col-lg-3" style="height:90%;overflow-x: hidden;overflow-y: auto;word-wrap:break-word;">
            <table class="table table-responsive" id="users-table">
                <thead>
                    <th>Username</th>
                </thead>
                <tbody> 
                @foreach($listUser as $listUser)
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

