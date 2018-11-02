@extends('backend.layouts.default')

@section('content')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>

    <div id="app">
        <create></create>
    </div>
@endsection
