@extends("layouts.app")


@section('content')



    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" style="background: white">


        <!-- Example row of columns -->
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="{{ route('projects.store') }}" method="post" role="form">

                    {{ csrf_field() }}


                    <legend>Create a new project</legend>

                    @if (!is_null($company_id))
                        <input type="hidden" class="form-control" name="company_id" id="company-id"
                               value="{{ $company_id }}"
                        />
                    @else
                        <div class="form-group">
                            <label for="company-id">Select the company <span class="required">*</span></label>
                            <select class="form-control" name="company_id" id="company_id">
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="project-name">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" id="project-name" placeholder="Project name"
                               required spellcheck="false"
                        />
                    </div>

                    <div class="form-group">
                        <label for="project-description">Description</label>
                        <textarea class="form-control autosize-target text-left"
                                  name="description"
                                  id="project-name"
                                  placeholder="Project description"
                                  rows="5"
                                  spellcheck="false"
                                  style="resize: vertical"
                        ></textarea>
                    </div>

                    <nav class="navbar navbar-default navbar-fixed-bottom">
                        <div class="container">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="#">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </form>
            </div>

        </div>
    </div>

    <div class="pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="{{ route('projects.index') }}">All projects</a></li>
            </ol>
        </div>

    </div>

@endsection