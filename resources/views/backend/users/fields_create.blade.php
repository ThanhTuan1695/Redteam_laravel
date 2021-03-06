<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password',['class' => 'form-control']) !!}
</div>

<!-- Re-Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password_confirmation', 'Password confirmation:') !!}
    {!! Form::password('password_confirmation',['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">	
    {!! Form::label('role', 'Role') !!}
    {!! Form::select('role',['1' => 'Admin' , '2' => 'User'],null, ['class' => 'form-control']) !!}
</div>

<!-- Avatar Field -->
<div class="col-lg-12">
    <div class="form-group">
        {{ Form::file('avatar',['class' => 'control','id' => 'files']) }}
    </div>
    <div id="selectedFiles"></div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>