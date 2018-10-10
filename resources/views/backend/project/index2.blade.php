@extends('adminlte::page')

@section('content_header')
    <h1>List projects</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Projects</li>
    </ol>
@stop

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


    <div class="row" id="load">
        @if (count($projects) > 0)
            <section class="projects">
                @include('backend.project.load')
            </section>
        @endif
    </div>




@endsection