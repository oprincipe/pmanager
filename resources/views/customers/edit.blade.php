@extends("layouts.app")


@section('content')

    <div class="row">

        <form action="{{ route('customers.update', ['customer_id' => $customer->id]) }}" method="post" role="form">

            <input type="hidden" name="_method" value="put" />

            {{ csrf_field() }}

            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Editing: {{ $customer->fullName() }}</h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="customer-type">Type <span class="required">*</span></label>
                                <select class="form-control" id="customer-type" name="type">
                                    <option value="private" @if($customer->type == 'private') selected="selected" @endif>Private</option>
                                    <option value="pro" @if($customer->type == 'pro') selected="selected" @endif>Professionist</option>
                                    <option value="company" @if($customer->type == 'company') selected="selected" @endif>Company</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="customer-name">Name / Company name <span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" id="customer-name"
                                       placeholder="Name (or Company name)"
                                       required spellcheck="false" value="{{ old("name", $customer->name) }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="customer-surname">Surname</label>
                                <input type="text" class="form-control" name="surname" id="customer-surname"
                                       placeholder="Surname"
                                       spellcheck="false" value="{{ old("surname", $customer->surname) }}"
                                />
                            </div>


                            <div class="form-group">
                                <label for="customer-pid">Personal ID (Fiscal code)</label>
                                <input type="text" class="form-control" name="pid" id="customer-pid"
                                       placeholder="Personal ID"
                                       spellcheck="false" value="{{ old("pid", $customer->pid) }}"
                                />
                            </div>

                            <div class="form-group">
                                <label for="customer-vat">VAT code</label>
                                <input type="text" class="form-control" name="vat" id="customer-vat"
                                       placeholder="VAT Code"
                                       spellcheck="false" value="{{ old("vat", $customer->vat) }}"
                                />
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-phone"></i> <i class="fa fa-at"></i>
                                                Contacts</h3>
                                        </div>
                                        <div class="panel-body">

                                            <div class="form-group">
                                                <label for="customer-email">Email <span class="required">*</span></label>
                                                <input type="email" class="form-control" name="email" id="customer-email"
                                                       placeholder="Email"
                                                       required spellcheck="false" value="{{ old("email", $customer->email) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-pec">Pec</label>
                                                <input type="email" class="form-control" name="pec" id="customer-pec"
                                                       placeholder="Pec"
                                                       spellcheck="false" value="{{ old("pec", $customer->pec) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-phone">Phone</label>
                                                <input type="text" class="form-control" name="phone" id="customer-phone"
                                                       placeholder="Phone"
                                                       spellcheck="false" value="{{ old("phone", $customer->phone) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-mobile">Mobile</label>
                                                <input type="text" class="form-control" name="mobile" id="customer-mobile"
                                                       placeholder="Mobile"
                                                       spellcheck="false" value="{{ old("mobile", $customer->mobile) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-fax">Fax</label>
                                                <input type="text" class="form-control" name="fax" id="customer-fax"
                                                       placeholder="Fax"
                                                       spellcheck="false" value="{{ old("fax", $customer->fax) }}"
                                                />
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-street-view"></i> Address informations</h3>
                                        </div>
                                        <div class="panel-body">

                                            <div class="form-group">
                                                <label for="customer-address">Address</label>
                                                <input type="text" class="form-control" name="address" id="customer-address"
                                                       placeholder="Address"
                                                       spellcheck="false" value="{{ old("address", $customer->address) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-city">City</label>
                                                <input type="text" class="form-control" name="city" id="customer-city"
                                                       placeholder="City"
                                                       spellcheck="false" value="{{ old("city", $customer->city) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-pcode">Postal code</label>
                                                <input type="text" class="form-control" name="pcode" id="customer-pcode"
                                                       placeholder="Postal code"
                                                       spellcheck="false" value="{{ old("pcode", $customer->pcode) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-province">Province</label>
                                                <input type="text" class="form-control" name="province" id="customer-province"
                                                       placeholder="Province"
                                                       spellcheck="false" value="{{ old("province", $customer->province) }}"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="customer-country">Country</label>
                                                <input type="text" class="form-control" name="country" id="customer-country"
                                                       placeholder="Country"
                                                       spellcheck="false" value="{{ old("country", $customer->country) }}"
                                                />
                                            </div>

                                            <script>
                                                document.getElementById("customer-name").focus();
                                            </script>

                                        </div>
                                    </div>
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
                        @include("partials.save-action")

                        <hr >
                        <ol class="list-unstyled">
                            <a href="{{ route("customers.index") }}"
                               ><i class="fa fa-users"></i> Back to list</a>
                        </ol>

                    </div>
                </div>

                @include("partials.customers.credentials-form")

            </div>

        </form>
    </div>
@endsection