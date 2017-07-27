@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')
@section('content')
    <section class="content-header">
        <h1>
            Select Admin
        </h1>
    </section>
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                <form action="{{ route('changeAdmin',$id) }}" method="get">
                    <div class="form-group col-sm-6">
                        {!! Form::label('user_id', 'Admin:') !!}
                        <select name="select" class="form-control">
                            @foreach($listUser as $listUser)
                                <option value="{{ $listUser->id }}">{{ $listUser->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Change', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('callback', $id) !!}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection