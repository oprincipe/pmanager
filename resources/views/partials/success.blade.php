@if (session()->has('success'))
    <div id="success-alert" class="alert alert-dismissable alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>
            {!! session()->get('success') !!}
        </strong>
    </div>
    <script>
        $(function(){
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#success-alert").slideUp();
            });
        });
    </script>
@endif