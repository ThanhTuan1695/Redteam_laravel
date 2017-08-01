@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
@section('name-conv')
    <div class="name-conv" style="margin-bottom:20px">
        <h3 style="display:inline"><span>@</span>{!! $user->username !!}</h3>
    </div>
@endsection
@include('frontend.layouts.content.content')
@section('scripts')


    @include('frontend.layouts.script.message')
    {{-- @include('frontend.layouts.script.pickerEmotion') --}}

@endsection
@endsection

