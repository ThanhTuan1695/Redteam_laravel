@extends('frontend.layouts.app')
@include('frontend.layouts.sidebar')

@section('content')
    <section class="content-header">
        <h1>
            Profile : <strong>{{ Auth::user()->username }}</strong>
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        @include('flash::message')
        <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($user, ['route' => ['updateProfile', $user->id], 'method' => 'post','files' => 'true', 'enctype'=>'multipart/form-data']) !!}
                        <div class="form-group col-sm-6">
                            {!! Form::label('name', 'Username:') !!}
                            {!! Form::text('username', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('current-password', 'Current-password:') !!}
                            {!! Form::password('current-password',['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('password', 'New-password:') !!}
                            {!! Form::password('password',['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-6">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group"><br>
                                {{ Form::file('avatar',['class' => 'control','id' => 'files']) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div id="selectedFiles">
                                <div class="col-lg-4">
                                @if ($user->avatar != null && file_exists(public_path('/backend/images/upload/'.$user->avatar)))
                                    <img style="width:300px;height:200px;margin-bottom:10px;" src="{{ url('/backend/images/upload/'.$user->avatar) }}" 
                                    class = "setpicture img-thumbnail img_upload" id ="image_no"></img><br>
                                @else 
                                    <img style="width:300px;height:200px;margin-bottom:10px;" src="{{ url('/backend/no_image.jpg') }}" 
                                    class = "setpicture img-thumbnail img_upload" id ="image_no"></img><br>
                                @endif
                                </div>
                            </div> 
                        </div> 

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <input  class="btn btn-default" type="reset" value="Cancel" />
                        </div>

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
    </div>
@endsection