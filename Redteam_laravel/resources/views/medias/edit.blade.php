@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Medias
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($medias, ['route' => ['medias.update', $medias->id], 'method' => 'patch']) !!}

                        @include('medias.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection