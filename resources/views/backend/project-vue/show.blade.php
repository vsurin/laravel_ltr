@extends('backend.layouts.default')

@section('content_header')
    <h1>Show project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Show project</li>
    </ol>
@stop

@section('content')
    <div id="app">
        <show id="{{ $id  }}"></show>
    </div>
@endsection
