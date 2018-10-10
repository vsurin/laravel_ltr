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

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('projects.create') }}">Add Project</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>

    <div class="projects" id="load">
        @include('backend.project.load')
    </div>

    <script type="text/javascript">

        (function($){
            $(function() {
                $('body').on('click', '.pagination a', function(e) {
                    e.preventDefault();

                    $('#load a').css('color', '#dfecf6');

                    var url = $(this).attr('href');
                    getProjects(url);
                });

                function getProjects(url) {
                    $.ajax({
                        url : url
                    }).done(function (data) {
                        $('.projects').html(data);
                    }).fail(function () {
                        alert('Projects could not be loaded.');
                    });
                }
            });
        })(jQuery);
    </script>
@endsection