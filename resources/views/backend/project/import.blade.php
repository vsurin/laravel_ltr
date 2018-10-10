@extends('adminlte::page')

@section('content_header')
    <h1>Import project</h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Import project</li>
    </ol>
@stop

@section('content')
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

    {!! Form::open(['method' => 'POST','route' => ['admin.project.parserFile'], 'enctype' => 'multipart/form-data']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="photo">File:</label>
                    {!! Form::file('file') !!}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection