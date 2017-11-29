@extends("layouts.app")


@section('content')
    <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Companies
                <a class="pull-right btn btn-success btn-sm" href="{{ URL::to('/companies/create') }}">Create new company</a>
                </div>
            </div>
            <div class="panel-body">

                <ul class="list-group">
                    @foreach($companies as $company)

                        <li class="list-group-item">
                            <a href="{{ URL::to("/companies/".$company->id) }}">
                            {{ $company->name }}
                            </a>
                        </li>

                    @endforeach
                </ul>

            </div>
        </div>
    </div>
    </div>
@endsection