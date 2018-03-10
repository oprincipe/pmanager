@extends('adminlte::page')

@section('title', 'Dashboard')

@section('navbar_elements')
    @if(Auth()->user())
    <li>
        <a href=""><i class="fa fa-user"></i> {{ Auth()->user()->fullName() }}</a>
    </li>
    @endif
@stop

@section('content_header')
    <h1>Dashboard</h1>
@stop


@section('css')
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-fixed-side.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="{{ asset('unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
@stop

@section('js')
    <script src="{{ asset('js/app.js') }}"></script>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop


@section('add_script')
@stop
