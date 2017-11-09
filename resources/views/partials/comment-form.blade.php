@if (isset($commentable_id))
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Insert new comment</h3>
        </div>
        <div class="panel-body">
            <form action="{{ route('comments.store') }}" method="post" role="form">

                {{ csrf_field() }}

                <input type="hidden" name="commentable_type" id="commentable_type" value="{{ $commentable_type }}" />
                <input type="hidden" name="commentable_id" id="commentable_id" value="{{ $commentable_id }}" />

                <div class="form-group">
                    <textarea class="form-control autosize-target text-left"
                              name="body"
                              id="comment-content"
                              placeholder="Type your comment"
                              required
                              rows="3"
                              spellcheck="false"
                              style="resize: vertical"
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="comment-url">Proof of work done (Url/Photos)</label>
                    <textarea class="form-control autosize-target text-left"
                              name="url"
                              id="comment-url"
                              placeholder="Enter url or screenshots"
                              rows="2"
                              spellcheck="false"
                              style="resize: vertical"
                    ></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-sm">Submit comment</button>
            </form>
        </div>
    </div>

@endif