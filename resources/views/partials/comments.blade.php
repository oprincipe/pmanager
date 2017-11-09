<div class="row">
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Comments</h3>
            </div>
            <div class="panel-body">
                @if (isset($comments) && count($comments) > 0)
                    @foreach($comments as $comment)

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>{{ $comment->user->fullName() }}</strong>
                                <span class="pull-right">

                                    <a href="#"
                                       onclick="
                                       var result = confirm('Are you sure you wish to delete this comment?');
                                       if(result) {
                                           event.preventDefault();
                                           $('#delete-comment-{{ $comment->id }}').submit();
                                       }"><i class="fa fa-trash"></i></a>

                                    <form id="delete-comment-{{ $comment->id }}" action="{{ route("comments.destroy", [$comment->id]) }}"
                                          method="post" style="display: none">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete" />
                                    </form>

                                </span>
                            </div>
                            <div class="panel-body">
                                <span class="text-muted">{{ $comment->created_at->format('d/m/Y H:i:s') }}</span>
                                <p class="text-danger">{{ $comment->url }}</p>
                                {{ $comment->body }}
                            </div><!-- /panel-body -->
                        </div><!-- /panel panel-default -->

                    @endforeach
                @else
                    <em>No comments yet</em>
                @endif
            </div>
        </div>
    </div>
</div>
