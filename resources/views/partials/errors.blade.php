<?php
$error_msgs = @$errors->all();
?>
@if(!empty($error_msgs))
    <div id="errors-alert" class="alert alert-dismissable alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>
            <div class="row">
            <ul>
            @foreach ($error_msgs as $error)
                <li><strong>{!! $error !!}</strong></li>
            @endforeach
            </ul>
            </div>
        </strong>
    </div>
@endif