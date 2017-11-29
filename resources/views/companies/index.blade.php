@extends("layouts.app")


@section('content')
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Companies
                    @if(Auth::user()->role_id == 1)
                    <a class="pull-right btn btn-success btn-sm" href="{{ URL::to('/companies/create') }}">Create new company</a>
                    @endif
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