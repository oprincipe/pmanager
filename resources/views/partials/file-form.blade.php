@if (isset($uploadable_id))
    <form action="{{ route('files.store') }}" method="post" role="form" enctype="multipart/form-data">

        {{ csrf_field() }}

        <input type="hidden" name="uploadable_type" id="uploadable_type" value="{{ $uploadable_type }}" />
        <input type="hidden" name="uploadable_id" id="uploadable_id" value="{{ $uploadable_id }}" />


        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Attachments
                    <span class="pull-right">
                    <button class="btn btn-sm btn-success" type="submit" style="margin-top: -7px">
                        <i class="glyphicon glyphicon-floppy-disk"></i> Upload
                    </button>
                </span>
                </h3>
            </div>
            <div class="panel-body">

                <div class="input-group">
                    <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip;
                        <input type="file"
                               name="filename"
                               id="file-filename"
                               placeholder="Select a file to attach"
                               spellcheck="false"
                               style="display: none;"
                        />
                    </span>
                    </label>
                    <input type="text" class="form-control" readonly>

                </div>

            </div>
        </div>

    </form>
@endif