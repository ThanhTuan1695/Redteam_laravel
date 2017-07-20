@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Messages
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($messages, ['route' => ['messages.update', $messages->id], 'method' => 'patch']) !!}

                        @include('backend.messages.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
