@extends("layouts.app")


@section('content')

    <div class="row">

        <form action="{{ route('projects.update', [$project->id]) }}" method="post" role="form">

            {{ csrf_field() }}

            <input type="hidden" name="_method" value="put" />

            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">


                <!-- Example row of columns -->
                <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                        <div class="well">
                            <h3>Project: {{ $project->name }}</h3>
                            <div class="row container-fluid">
                                Created at: {{ $project->created_at->format('d/m/Y h:i:s') }}
                                <br />
                                Updated at: {{ $project->updated_at->format('d/m/Y h:i:s') }}
                            </div>
                        </div>

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"></h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="project-user-id">Owner <span class="required">*</span></label>
                                    @if(Auth::user()->role_id == App\Role::SUPER_ADMIN)
                                        <select class="form-control" name="user_id" id="user_id">
                                            @foreach($users as $owner)
                                                <option value="{{ $owner->id }}"
                                                        @if($owner->id == $project->user_id)
                                                        selected="selected"
                                                        @endif
                                                >{{ $owner->fullName() }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        {{ $project->user->fullName() }}
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="project-name">Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" id="project-name"
                                           placeholder="Project name"
                                           required spellcheck="false" value="{{ $project->name }}"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="project-description">Description</label>
                                    <textarea class="form-control autosize-target text-left"
                                              name="description"
                                              id="project-description"
                                              placeholder="Project description"
                                              rows="15"
                                              spellcheck="false"
                                              style="resize: vertical"
                                    >{!! $project->description  !!}</textarea>
                                    <script>
                                        CKEDITOR.replace('project-description');
                                    </script>
                                </div>

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
                    <ol class="list-unstyled">
                        <li><a href="{{ URL::to('/projects/'.$project->id) }}"><i class="fa fa-briefcase"></i> View
                                                                                                               project</a>
                        </li>
                    </ol>
                    </div>
                </div>

                @include("partials.save-navbar")

            </div>

        </form>
    </div>
@endsection