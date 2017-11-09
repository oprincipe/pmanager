@if ( isset($errors) && count($errors) > 0 )
    <div id="errors-alert" class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
            <div class="row">
            <ul>
            @foreach ($errors->all() as $error)
                <li><strong>{!! $error !!}</strong></li>
            @endforeach
            </ul>
            </div>
        </strong>
    </div>
    <script>
        $(function(){
            $("#errors-alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#errors-alert").slideUp();
            });
        });
    </script>
@endif