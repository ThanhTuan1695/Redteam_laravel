@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
@section('name-conv')
    <div class="name-conv" style="margin-bottom:20px">
        <h3 style="display:inline"><span>@</span>
            <a href="{{ route('viewDetail', $id) }}" >
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
@include('frontend.layouts.content.content')
@section('scripts')
    @include('frontend.layouts.script.message')
@endsection
@endsection

