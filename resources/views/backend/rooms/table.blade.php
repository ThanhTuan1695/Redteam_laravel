<table class="table table-responsive" id="rooms-table">
    <thead>
        <th>Name</th>
        <th>User Id</th>
        <th>Description</th>
        <th>Type</th>
        <th>Action</th>
    </thead>
    <tbody>
    @foreach($rooms as $rooms)
        <tr>
            <td>{!! $rooms->name !!}</td>
            <td>{!! $rooms->user_id !!}</td>
            <td>{!! $rooms->description !!}</td>
            <td>{!! $rooms->type !!}</td>
            <td>
                {!! Form::open(['route' => ['rooms.destroy', $rooms->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('rooms.show', [$rooms->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('rooms.edit', [$rooms->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>