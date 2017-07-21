
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<!-- Current-Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('current-password', 'Current-password:') !!}
    {!! Form::password('current-password',['class' => 'form-control']) !!}
</div>

<!-- New-Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'New-password:') !!}
    {!! Form::password('password',['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'readonly']) !!}
</div>

<div class="col-lg-12">
    <div class="form-group">
        {{ Form::file('avatar',['class' => 'control','id' => 'files']) }}
    </div>
     <div id="selectedFiles">
        <div class="col-lg-4">
            <img style="width:300px;height:200px;margin-bottom:10px;" src="{{ url('/backend/images/upload/'.$user->avatar) }}" 
            class = "setpicture img-thumbnail img_upload" id ="image_no"></img><br>
        </div>
    </div> 
</div> 

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>