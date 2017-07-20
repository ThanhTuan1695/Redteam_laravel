@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Users
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'users.store','files' => 'true', 'enctype'=>'multipart/form-data' ]) !!}

                        @include('backend.users.fields_create')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('backend/js/displayimages.js')}}"></script>
@endsection