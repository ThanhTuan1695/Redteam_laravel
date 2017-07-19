<!-- Content Field -->
<div class="form-group col-sm-6">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::text('content', null, ['class' => 'form-control']) !!}
</div>

<!-- Id User Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_user', 'Id User:') !!}
    {!! Form::text('id_user', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Room Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_room', 'Id Room:') !!}
    {!! Form::text('id_room', null, ['class' => 'form-control']) !!}
</div>

<!-- Id Single Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id_single', 'Id Single:') !!}
    {!! Form::text('id_single', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('messages.index') !!}" class="btn btn-default">Cancel</a>
</div>
