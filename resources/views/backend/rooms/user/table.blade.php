<table class="table table-responsive" id="user-table">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Avatar</th>
        <th>Action</th>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            @if($user->role == 1)
                <td>Admin</td>
            @else
                <td>User</td>
            @endif
            <td>{{ $user->avatar }}</td>
            <td>
                {!! Form::open(['route' => ['room.user.destroy',$room->id, $user->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('users.show', [$user->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('users.edit', [$user->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>