@extends('adminlte::page')

@section('content_header')
    <h1>Show project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Show project</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" id="generate" href="{{ route('admin.project.pdf') }}">Generate PDF</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div>
                <label>Title:</label>
                {{ $project->title }}
            </div>
            <div>
                <label>E-Mail:</label>
                {!! $project->organization !!}
            </div>
            <div>
                <label>Start:</label>
                {!! $project->start !!}
            </div>
            <div>
                <label>End:</label>
                {!! $project->end !!}
            </div>
            <div>
                <label>Role:</label>
                {!! $project->role !!}
            </div>
            <div>
                <label>Link:</label>
                {!! $project->link !!}
            </div>
            <div>
                <label>Type:</label>
                {!! $project->type !!}
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script type="text/javascript">
        (function($){
            $(function() {
                $('#generate').on('click', function() {
                    $.ajax({
                        url : location.href,
                        data: {title: 'test'}
                    }).done(function (data) {
                        console.log(data);
                    }).fail(function () {
                        alert('Projects could not be loaded.');
                    });
                });
            });
        })(jQuery);
    </script>
@endsection