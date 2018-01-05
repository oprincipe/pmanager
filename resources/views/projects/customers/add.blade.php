<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Assign customer</h3>
    </div>
    <div class="panel-body">
        <form action="{{ route('customerproject.store') }}" method="post" role="form">

            {{ csrf_field() }}

            <input type="hidden" name="project_id" id="customer_project_id" value="{{ $project->id }}" />

            <div class="form-group">
                <label for=""></label>
                <select id="customer_id" name="customer_id" class="form-control">
                    @forelse($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->fullName() }}</option>
                    @empty
                        <option value="">No customers availables</option>
                    @endforelse
                </select>
            </div>

            @if(!$customers->isEmpty())
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Assign to project</button>
            @endif
        </form>

        @include("projects.customers.list")

    </div>
</div>