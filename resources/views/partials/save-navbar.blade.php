<div class="panel panel-default">
    <div class="panel-body">
        @include("partials.save-action")

        @if(!empty($task) && $task->id > 0)
            <div class="no-padding">
                <br />
                <input type="checkbox" id="send_email" name="send_email" class="minimal"
                       checked="checked"
                       value="1"
                >
                <label for="send_email">
                    Send notification by mail
                </label>
            </div>
        @endif
    </div>
</div>