<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use function strtolower;

class File extends Model
{
    protected $fillable = [
		'filename',
		'ext',
		'type',
		'size',
		'filepath',
		'uploadable_id',
		'uploadable_type',
		'user_id'
    ];

    public function uploadable()
    {
    	return $this->morphTo();
    }

	public function user()
	{
		return $this->belongsTo("App\User");
	}

	public function getRealPath()
	{
		$path =  Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix($this->filepath);
		$path = str_replace("\\", "/", $path);
		return $path;
	}

	public function delete()
	{
		if(parent::delete()) {
			//Delete file from storage if exists
			$exists = Storage::disk('local')->exists($this->filepath);
			if($exists) {
				Storage::disk('local')->delete($this->filepath);
			}
			return true;
		}
		else {
			return false;
		}
	}

	public function getIcon()
	{
		switch (strtolower($this->ext)):
			case "zip":
			case "gzip":
			case "bz2":
			case "tar":
			case "rar":
			case "gz":
				return "fa fa-file-archive-o";

			case "jpg":
			case "jpeg":
			case "gif":
			case "png":
			case "tiff":
				return "fa fa-file-image-o";

			case "pdf":
				return "fa fa-file-pdf-o";

			case "doc":
			case "docx":
			case "rtf":
			case "odt":
				return "fa fa-file-word-o";

			case "xls":
			case "xlsx":
			case "xl":
				return "fa fa-file-excel-o";

			case 'mpeg':
			case 'mpg':
			case 'mpe':
			case 'qt':
			case 'mov':
			case 'avi':
			case 'movie':
			case 'wmv':
			case 'mp4':
				return "fa fa-file-movie-o";

			case 'wma':
			case 'mp3':
			case 'wav':
				return "fa fa-file-audio-o";

			case "php":
			case "js":
			case "css":
			case "asp":
			case "jsp":
			case "html":
				return "fa fa-file-code-o";

			case "txt":
				return "fa fa-file-text-o";

			default:
				return "fa fa-file-o";

		endswitch;
	}
}
