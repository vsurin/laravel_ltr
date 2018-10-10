@extends('adminlte::page')

@section('content_header')
    <h1>Create project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create project</li>
    </ol>
@stop

@section('content')
    {!! Form::open(array('route' => 'projects.store','method'=>'POST', 'enctype' => 'multipart/form-data')) !!}
    @include('backend.project.form')
    {!! Form::close() !!}
@endsection