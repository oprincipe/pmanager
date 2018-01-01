<br />
<legend>Project customers</legend>
<ul class="list-group">

    @forelse($customers_project as $customer)
        <li class="list-group-item">
            <span class="pull-right">
                <a href="#"
                   onclick="
                           var result = confirm('Are you sure you wish to unlink this customer from the project?');
                           if(result) {
                           event.preventDefault();
                           $('#unlink-customer-project-{{ $customer->id }}').submit();
                           }"><i class="fa fa-trash"></i></a>

                <!-- URL::to("/customerproject/".$customer->id."/".$project->id."unlink") -->

                <form id="unlink-customer-project-{{ $customer->id }}" action="{{ route("customerproject.unlink", [$customer->id, $project->id]) }}"
                      method="post" style="display: none">
                        {{ csrf_field() }}
                    <input type="hidden" name="_method" value="GET" />
                </form>
            </span>
            {{ $customer->fullName() }}
        </li>
    @empty
        <li class="list-group-item">No customers on this project yet</li>
    @endforelse
</ul>