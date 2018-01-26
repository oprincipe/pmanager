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

                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Full address</th>
                            <th>Base price</th>
                            <th>Phone</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>
                                <a href="{{ route("customers.edit", $customer->id) }}"><i
                                            class="fa fa-pencil-square-o"></i></a>
                            </td>
                            <td>
                                <a href="{{ route("customers.edit", $customer->id) }}">
                                    {{ $customer->fullName() }}
                                </a>
                            </td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->fullAddress() }}</td>
                            <td>{{ money($customer->base_price, "EUR") }} / h</td>
                            <td>{{ $customer->phone }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection