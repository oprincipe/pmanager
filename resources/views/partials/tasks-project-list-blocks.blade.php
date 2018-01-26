@section("js")
<script>
    var dragSrcEl = null;
    var dropToStatus = null;

    function handleDragStart(e) {
        this.style.opacity = '0.4';  // this / e.target is the source node.

        dragSrcEl = this;

        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);

    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault(); // Necessary. Allows us to drop.
        }

        e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

        return false;
    }

    function handleDragEnter(e) {
        // this / e.target is the current hover target.
        this.classList.add('over');
    }

    function handleDragLeave(e) {
        this.classList.remove('over');  // this / e.target is previous target element.
    }

    function handleDrop(e) {

        if(e.target.id !== null) {
            //Set the target id
            dropToStatus = e.target.id;
        }

        if (e.stopPropagation) {
            e.stopPropagation(); // Stops some browsers from redirecting.
        }


        // Don't do anything if dropping the same column we're dragging.
        if (dropToStatus != null && dropToStatus !== "") {

        }

        return false;
    }

    function handleDragEnd(e) {
        // this/e.target is the source node.
        $('.tag_row').each(function() {
            this.classList.remove('over');
            this.style.opacity = '1';
        });

        var _task_id = dragSrcEl.id.replace("task_id_","");
        var _new_status = dropToStatus.replace("task_status_table_","");
        ajax_changeTaskStatus({{ $project->id }}, _task_id, _new_status);
        console.log("Start drop ... " + _task_id + " to status = " + _new_status);
    }




    function ajax_getProjectTasksByStatus(_project_id, _task_status_id) {

        $("#panel-body-status-" + _task_status_id).html('<img src="{{ asset("images/ajax-loader.gif") }}" border="0" title="Loading" />');
        $("#panel-body-status-loading-" + _task_status_id).find("i").addClass("fa-spin");


        $.post("{{ route("projects.get_tasks_by_status") }}",
            {
                project_id: _project_id,
                task_status_id: _task_status_id,
                _token: '{{csrf_token()}}'
            },
            function (data) {
                $("#panel-body-status-loading-" + _task_status_id).find("i").removeClass("fa-spin");
                $("#panel-body-status-" + _task_status_id).html(data.html);

                $('.tag_row').each(function() {
                    this.addEventListener('dragstart', handleDragStart, false);
                    //row.addEventListener('dragenter', handleDragEnter, false);
                    //row.addEventListener('dragover', handleDragOver, false);
                    this.addEventListener('dragleave', handleDragLeave, false);
                    //row.addEventListener('drop', handleDrop, false);
                    //row.addEventListener('dragend', handleDragEnd, false);
                    this.addEventListener('dragend', handleDragEnd, false);
                });

                $('.droppable').on('drop dragdrop dragleave', handleDrop);
            }
            , "json");
    }


    function ajax_changeTaskStatus(_project_id, _task_id, _new_status_id) {
        $.post("{{ route("projects.change_task_status") }}",
            {
                project_id: _project_id,
                task_id: _task_id,
                task_status_id: _new_status_id,
                _token: '{{csrf_token()}}'
            },
            function (data) {
                if(data.err) {
                    displayErrorMessage(data.msg);
                }
                else {
                    displaySuccessMessage(data.msg);
                    ajax_getProjectTasksByStatus(data.project.id, data.task.status_id);
                    ajax_getProjectTasksByStatus(data.project.id, data.old_status.id);
                }
            }
            , "json");
    }



    @foreach($task_statuses as $task_status)
        ajax_getProjectTasksByStatus({{ $project->id }}, {{ $task_status->id }});
    @endforeach

</script>
@endsection

@foreach($task_statuses as $task_status)
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="task_icon">
                {!! $task_status->icon() !!}
            </span>
            <span id="panel-body-status-loading-{{ $task_status->id }}">
                <button class="btn btn-link" style="color: white;" type="button"
                        title="Refresh" onclick="ajax_getProjectTasksByStatus({{ $project->id }}, {{ $task_status->id }})"
                ><i class="fa fa-refresh"></i></button>
            </span>
            <span>{{ ucfirst($task_status->name) }}</span>
            <span class="badge"><?=(int) $project->tasks_count($task_status->id)?></span>

            <span class="pull-right">
                <a style="color: white" href="{{ route('tasks.create')."/".$project->id }}">
                    <i class="glyphicon glyphicon-plus"></i>
                </a>
            </span>
        </h3>
    </div>
    <div class="panel-body" id="panel-body-status-{{ $task_status->id }}">

    </div>
</div>
@endforeach