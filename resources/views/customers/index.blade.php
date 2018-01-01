@extends("layouts.app")

@section('content_header')
    <h1>Customers</h1>
@endsection;

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">Customers list
                        <a class="pull-right btn btn-success btn-sm" href="{{ route("customers.create") }}"
                        >Create new customer</a>
                    </div>
                </div>
                <div class="panel-body">

                    <ul class="list-group">
                        @foreach($customers as $customer)

                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-xs-1">
                                        <a href="{{ route("customers.edit", $customer->id) }}"><i
                                                    class="fa fa-pencil-square-o"></i></a>
                                    </div>

                                    <div class="col-xs-3">
                                        <a href="{{ URL::to("/users/".$customer->id) }}">
                                            {{ $customer->fullName() }}
                                        </a>
                                    </div>

                                    <div class="col-xs-3">
                                        {{ $customer->email }}
                                    </div>

                                    <div class="col-xs-3">
                                        {{ $customer->fullAddress() }}
                                    </div>

                                    <div class="col-xs-2">
                                        {{ $customer->phone }}
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