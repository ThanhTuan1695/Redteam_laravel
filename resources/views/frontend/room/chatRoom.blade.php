@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
@section('name-conv')
    <div class="name-conv" style="margin-bottom:20px">
        <h3 style="display:inline"><span>@</span>{!! $get_room->name !!}</h3>
        <button style="float:right" type="submit" class="btn btn-default">
            <a href="{{ route('chooseUser', $id) }}">Add Member</a>
        </button>
    </div>
@endsection
@include('frontend.layouts.content.content')
@section('scripts')
    @include('frontend.layouts.script.message')
@endsection
@endsection

