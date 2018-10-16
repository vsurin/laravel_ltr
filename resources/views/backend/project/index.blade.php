@extends('backend.layouts.default')

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

    <div class="row">
        <div class="col-xs-2  col-sm-2 col-md-2">
            <div><strong>Title</strong></div>
            <input type="text" id="title">
        </div>
        <div class="col-xs-2  col-sm-2 col-md-2">
            <div><strong>Organization</strong></div>
            <input type="text" id="organization">
        </div>
        <div class="col-xs-2  col-sm-2 col-md-2">
            <div><strong>Type</strong></div>
            <input type="text" id="filtertype">
        </div>
    </div>

    <div class="projects" id="load">
        @include('backend.project.load')
    </div>
@endsection