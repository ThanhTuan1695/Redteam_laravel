<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    <select name="user_id" class="form-control">
        @foreach ($users as $user)
            <option value="{{$user->id}}">{{$user->name}}</option>
        @endforeach
    </select>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'rooms-textarea']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type') !!}
    <select name="type" class="form-control">
        <option value="public">Public</option>
        <option value="private">Private</option>
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('rooms.index') !!}" class="btn btn-default">Cancel</a>
</div>
