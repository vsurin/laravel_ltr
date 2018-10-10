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
@endsection