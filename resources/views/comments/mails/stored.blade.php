@component('mail::message')

<h5>{{ $comment->commentable->name }}</h5>

@component('mail::panel')
{!! strip_tags($comment->body) !!}
@endcomponent


@component('mail::button', ['url' => $view_url])
View comment
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent
