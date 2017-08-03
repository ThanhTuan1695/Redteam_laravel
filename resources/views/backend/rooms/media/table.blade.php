<table class="table table-responsive" id="media-table">
    <thead>
        <th>Name</th>
        <th>Url</th>
        <th>Type</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($medias as $media)
        <tr>
            <td>{!! $media->name !!}</td>
            <td>{!! $media->url !!}</td>
            <td>{!! $media->type !!}</td>
            <td>
                {!! Form::open(['route' => ['media.destroy',$id, $media->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>