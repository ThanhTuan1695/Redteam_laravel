@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">{{$room->name}}</h1>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('backend.rooms.user.table')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){ 
            $('#media-table').DataTable();
        });
    </script>
@endsection