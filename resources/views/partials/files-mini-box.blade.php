<div class="row">
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Files</h3>
            </div>
            <div class="panel-body">
                @if (isset($files) && count($files) > 0)


                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Actions</th>
                            <th>File name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($files as $file)
                            <tr>
                                <td>
                                    <a href="{{ URL::to("files/".$file->id) }}">
                                        <i class="fa fa-download" title="download"></i>
                                    </a>


                                    @if (Auth::user()->role_id == 1)
                                    <a href="#"
                                       onclick="
                                               var result = confirm('Are you sure you wish to delete this file?');
                                               if(result) {
                                               event.preventDefault();
                                               $('#delete-file-{{ $file->id }}').submit();
                                               }"><i class="fa fa-trash"></i></a>

                                    <form id="delete-file-{{ $file->id }}" action="{{ route("files.destroy", [$file->id]) }}"
                                          method="post" style="display: none">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete" />
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    <small>
                                        <span class="{{ $file->getIcon() }}"></span>
                                        {{ $file->filename }}
                                        <br />{{ FileDimensionHelper::bytesToHuman($file->size) }}
                                    </small>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @else
                    <em>No files yet</em>
                @endif
            </div>
        </div>
    </div>
</div>
