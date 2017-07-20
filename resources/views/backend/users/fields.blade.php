
<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Current-Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('current-password', 'Current-password:') !!}
    {!! Form::password('current-password',['class' => 'form-control', 'type' => 'password']) !!}
</div>

<!-- New-Password Field -->
<div class="form-group col-sm-6">
    {!! Form::label('password', 'New-password:') !!}
    {!! Form::password('password',['class' => 'form-control', 'type' => 'password']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'readonly']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('users.index') !!}" class="btn btn-default">Cancel</a>
</div>