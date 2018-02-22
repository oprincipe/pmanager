<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
	protected $table = "project_user";

    protected $fillable = [
    	"project_id",
	    "user_id"
    ];

    public function user()
    {
    	return $this->belongsTo("App\User");
    }

    public function project()
    {
    	return $this->belongsTo("App\Project");
    }

}
