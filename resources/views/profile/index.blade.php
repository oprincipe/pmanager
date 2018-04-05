@extends("layouts.app")


@section('content')

    <div class="row">

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">User: {{ $user->fullName() }}</h3>
                    <div class="row container-fluid">
                        Created at: {{ $user->created_at->format('d/m/Y h:i:s') }}
                        <br/>
                        Updated at: {{ $user->updated_at->format('d/m/Y h:i:s') }}
                    </div>
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        <label for="user-first-name">First Name <span class="required">*</span></label>
                        {{ $user->first_name }}
                    </div>

                    <div class="form-group">
                        <label for="user-middle-name">Middle Name</label>
                        {{ $user->middle_name }}
                    </div>

                    <div class="form-group">
                        <label for="user-last-name">Last Name</label>
                        {{ $user->last_name }}
                    </div>

                    <div class="form-group">
                        <label for="user-email">Email <span class="required">*</span></label>
                        {{ $user->email }}
                    </div>

                    <div class="form-group">
                        <label for="user-city">City</label>
                        {{ $user->city }}
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Avatar</h3>
                </div>
                <div class="panel-body">
                    <div class="profile-header-container">
                        <div class="profile-header-img">
                            <img class="img-circle" src="{{ $user->avatar() }}"/>
                            <!-- badge -->
                            <div class="rank-label-container">
                                <span class="label label-default rank-label">{{ $projects_count . " " . __("projects") }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="pull-right col-xs-12 col-sm-6 col-md-6 col-lg-3 blog-sidebar">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>
                </div>
                <div class="panel-body">

                    <ol class="list-unstyled">
                        <a href="{{ route("profile.edit") }}"
                        ><i class="fa fa-pencil"></i> Edit profile</a>
                    </ol>

                </div>
            </div>


        </div>

        </form>
    </div>
@endsection