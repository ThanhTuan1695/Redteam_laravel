<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Creator:') !!}
    @if (isset($rooms))
        {!! Form::select('user_id',$listUser,null,['class' => 'form-control']) !!}
    @else
        {!! Form::select('user_id',$listUser,null, ['class' => 'form-control']) !!}
    @endif
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'rooms-textarea']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type') !!}
    {!! Form::select('type',['public' => 'Public' , 'private' => 'Private'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('rooms.index') !!}" class="btn btn-default">Cancel</a>
</div>
