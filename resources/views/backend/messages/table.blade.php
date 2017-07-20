<table class="table table-responsive" id="messages-table">
    <thead>
        <th>Content</th>
        <th>User Id</th>
        <th>Room Id</th>
        <th>Single Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($messages as $messages)
        <tr>
            <td>{!! $messages->content !!}</td>
            <td>{!! $messages->user_id !!}</td>
            <td>{!! $messages->room_id !!}</td>
            <td>{!! $messages->single_id !!}</td>
            <td>
                {!! Form::open(['route' => ['messages.destroy', $messages->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('messages.show', [$messages->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('messages.edit', [$messages->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>