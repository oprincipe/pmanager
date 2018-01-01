@extends("layouts.app")

@section('content_header')
    <h1>Users</h1>
@endsection;

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Users list
                        <a class="pull-right btn btn-success btn-sm" href="{{ route("users.create") }}">Create new
                                                                                                        user</a>
                    </div>
                </div>
                <div class="panel-body">

                    <ul class="list-group">
                        @foreach($users as $user)

                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xs-1">
                                        <a href="{{ route("users.show", $user->id) }}"><i
                                                    class="fa fa-pencil-square-o"></i></a>
                                    </div>

                                    <div class="col-xs-3">
                                        <a href="{{ URL::to("/users/".$user->id) }}">
                                            {{ $user->fullName() }}
                                        </a>
                                    </div>

                                    <div class="col-xs-3">
                                        {{ $user->email }}
                                    </div>

                                    <div class="col-xs-3">
                                        {{ $user->city }}
                                    </div>

                                    <div class="col-xs-2">
                                        {{ $user->role->name }}
                                    </div>
                                </div>
                            </li>

                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection