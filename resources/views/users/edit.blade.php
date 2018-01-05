@extends("layouts.app")


@section('content')

    <div class="row">

        <form action="{{ route('users.update', [$user->id]) }}" method="post" role="form">

            {{ csrf_field() }}

            <input type="hidden" name="_method" value="put" />

            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">User: {{ $user->fullName() }}</h3>
                            <div class="row container-fluid">
                                Created at: {{ $user->created_at->format('d/m/Y h:i:s') }}
                                <br />
                                Updated at: {{ $user->updated_at->format('d/m/Y h:i:s') }}
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="user-role-id">Role <span class="required">*</span></label>
                                <select class="form-control" id="user-role-id" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                            @if($user->role_id == $role->id)
                                                selected="selected"
                                            @endif
                                        >{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user-first-name">First Name <span class="required">*</span></label>
                                <input type="text" class="form-control" name="first_name" id="user-first-name"
                                       placeholder="First name"
                                       required spellcheck="false" value="{{ $user->first_name }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="user-middle-name">Middle Name</label>
                                <input type="text" class="form-control" name="middle_name" id="user-middle-name"
                                       placeholder="Middle name"
                                       spellcheck="false" value="{{ $user->middle_name }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="user-last-name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="user-last-name"
                                       placeholder="last name"
                                       spellcheck="false" value="{{ $user->last_name }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="user-email">Email <span class="required">*</span></label>
                                <input type="email" class="form-control" name="email" id="user-email"
                                       placeholder="Email"
                                       required spellcheck="false" value="{{ $user->email }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="user-password">Password</label>
                                <input type="password" class="form-control" name="password" id="user-password"
                                       placeholder="Password to login"
                                       spellcheck="false" value=""
                                />
                            </div>

                            <div class="form-group">
                                <label for="user-city">City</label>
                                <input type="text" class="form-control" name="city" id="user-city"
                                       placeholder="User's city"
                                       spellcheck="false" value="{{ $user->city }}"
                                />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Actions</h3>
                    </div>
                    <div class="panel-body">
                        @include("partials.save-action")

                        <hr >
                        <ol class="list-unstyled">
                            <a href="{{ route("users.index") }}"
                               ><i class="fa fa-users"></i> Back to list</a>
                        </ol>

                    </div>
                </div>



            </div>

        </form>
    </div>
@endsection