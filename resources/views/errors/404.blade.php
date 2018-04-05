@extends("layouts.app")

@section('content_header')
    <h1>Error</h1>
@endsection

@section('content')
    <h2>{{ $exception->getMessage() }}</h2>
@endsection