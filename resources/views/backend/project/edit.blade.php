@extends('adminlte::page')

@section('content_header')
    <h1>Edit project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit project</li>
    </ol>
@stop

@section('content')
    {!! Form::model($project, ['method' => 'PATCH','route' => ['projects.update', $project->id], 'enctype' => 'multipart/form-data']) !!}
    @include('backend.project.form')
    {!! Form::close() !!}
@endsection