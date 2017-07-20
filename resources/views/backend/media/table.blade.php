<table class="table table-responsive" id="media-table">
    <thead>
        <th>Name</th>
        <th>Url</th>
        <th>Mgs Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($media as $media)
        <tr>
            <td>{!! $media->name !!}</td>
            <td>{!! $media->url !!}</td>
            <td>{!! $media->mgs_id !!}</td>
            <td>
                {!! Form::open(['route' => ['media.destroy', $media->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('media.show', [$media->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('media.edit', [$media->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>