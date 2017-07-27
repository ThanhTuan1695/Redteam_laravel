<!-- Fullname Field -->
<div class="form-group">
    {!! Form::label('name', 'Username:') !!}
    <p>{{ $user->username }}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $user->email }}</p>
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

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $user->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $user->updated_at !!}</p>
</div>

