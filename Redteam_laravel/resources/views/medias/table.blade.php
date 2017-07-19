<table class="table table-responsive" id="medias-table">
    <thead>
        <th>Name</th>
        <th>Url</th>
        <th>Id Msg</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($medias as $medias)
        <tr>
            <td>{!! $medias->name !!}</td>
            <td>{!! $medias->url !!}</td>
            <td>{!! $medias->id_msg !!}</td>
            <td>
                {!! Form::open(['route' => ['medias.destroy', $medias->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('medias.show', [$medias->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('medias.edit', [$medias->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>