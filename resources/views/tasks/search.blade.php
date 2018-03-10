<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 10/03/18
 * Time: 16:16
 */
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Search task</h3>
        </div>
        <div class="panel-body">
            <form action="{{ route("tasks.index") }}" method="get" class="form-inline" role="search">

                <div class="form-group">
                    <label class="sr-only" for="">Task status</label>
                    <select name="search_task_status_id" class="form-control select2">
                        <option value="">{{ __("All status") }}</option>
                        <option value="actives"
                                @if(!empty(Request::get("search_task_status_id")) && Request::get("search_task_status_id") == "actives")
                                    selected="selected"
                                @endif
                        >{{ __("Only active tasks") }}</option>
                        @foreach($task_statuses as $task_status)
                            <option value="{{ $task_status->id }}"
                                @if(!empty(Request::get("search_task_status_id")) && (int) Request::get("search_task_status_id") == $task_status->id)
                                    selected="selected"
                                @endif
                                title="{{ $task_status->name }}"
                            >{{ $task_status->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="sr-only" for="">Task name</label>
                    <input type="text" class="form-control" name="search_task_name"
                           id="search_task_name" placeholder="{{ __("Task name") }}"
                           value="{{ old("search_task_name", Request::get("search_task_name")) }}">
                </div>


                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
</div>