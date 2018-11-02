@extends('backend.layouts.default')

@section('content_header')
    <h1>List projects</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Projects</li>
    </ol>
@stop

@section('content')
    <div id="app">
        <index></index>
    </div>
@endsection
