@extends('backend.layouts.default')

@section('content')
    <div id="app">
        <div :is="currentComponent"></div>
    </div>
@endsection
