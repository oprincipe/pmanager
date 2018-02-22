@component('mail::message')

<h5>{{ $task->project->name }}</h5>
#{{ $task->name }}

#{{ $task_title }}

@component('mail::table')
    | Task       | Value        |
    | ---------- |-------------:|
    | Name   | {{ $task->name }}     |
    | Project   | {{ $task->project->name }} |
    | Status   | {{ $task->status->name }} |
    | Hours   | {{ $task->hours }} |
    | Created at   | {{ $task->created_at }} |
    | Updated at   | {{ $task->updated_at }} |
@endcomponent

@component('mail::panel')
{!! str_limit(strip_tags($task->description), $limit = 150, $end = '...') !!}
@endcomponent


@component('mail::button', ['url' => $view_url])
View task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
