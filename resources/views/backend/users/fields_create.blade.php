<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password',['class' => 'form-control', 'type' => 'password']) !!}
</div>

<!-- Re-Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password_confirmation', 'Password confirmation:') !!}
    {!! Form::password('password_confirmation',['class' => 'form-control', 'type' => 'password']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">	
    {!! Form::label('role', 'Role') !!}
    <select name="role" class="form-control">
    	<option value="1">Admin</option>
        <option value="2">User</option>
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>