@extends("layouts.app")

@section('content_header')
    <h1>Your profile</h1>
@endsection

@section('css')
    <link href="{{ asset('css/sticky_notes.css') }}" type="text/css" rel="stylesheet">
    <link  href="http://fonts.googleapis.com/css?family=Reenie+Beanie:regular" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/common.css') }}" type="text/css" rel="stylesheet">
@endsection


@section('content')

    <div class="row">

        <form action="{{ route('profile.update') }}" method="post" role="form" enctype="multipart/form-data">

        {{ csrf_field() }}

        <!--<input type="hidden" name="_method" value="put" />-->

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

                        <br/>

                        <div class="input-group image-preview">
                            <input placeholder="" type="text" class="form-control image-preview-filename"
                                   disabled="disabled">

                            <!-- don't give a name === doesn't send on POST/GET -->
                            <span class="input-group-btn">
						        <!-- image-preview-clear button -->
						        <button type="button" class="btn btn-default image-preview-clear" style="display:none;"> <span
                                        class="glyphicon glyphicon-remove"></span> Clear </button>

                                <!-- image-preview-input -->
						        <div class="btn btn-default image-preview-input"> <span
                                    class="glyphicon glyphicon-folder-open"></span> <span
                                    class="image-preview-input-title">Browse</span>
							        <input type="file" accept="image/jpeg"
                                           id="profile-file"
                                           name="profile-file"
                                    />
                                <!-- rename it -->
						        </div>
						    </span>
                        </div>
                        <!-- /input-group image-preview [TO HERE]-->

                        <br/>

                        <!-- Drop Zone -->
                        <div class="upload-drop-zone" id="profile-file-preview-container" style="display: none">
                            <div class="profile-header-container">
                                <div class="profile-header-img">
                                    <img id="profile-file-preview" class="img-circle" src=""/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="pull-right col-xs-12 col-sm-12 col-md-12 col-lg-3 blog-sidebar">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Actions</h3>
                    </div>
                    <div class="panel-body">
                        @include("partials.save-action")

                        <hr>
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



@section("add_script")
    <script>
        $('#profile-file').change(function(){
            readImgUrlAndPreview(this);
            function readImgUrlAndPreview(input){
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#profile-file-preview').attr('src', e.target.result);
                        $('#profile-file-preview-container').show();
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
@endsection