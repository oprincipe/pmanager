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

<div id="userMessage">
    <div class="alert alert-success" style="display: none">
        <strong>Success!</strong> Indicates a successful or positive action.
    </div>
    <div class="alert alert-info" style="display: none">
        <strong>Info!</strong> Indicates a neutral informative change or action.
    </div>
    <div class="alert alert-warning" style="display: none">
        <strong>Warning!</strong> Indicates a warning that might need attention.
    </div>
    <div class="alert alert-danger" style="display: none">
        <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
    </div>
</div>