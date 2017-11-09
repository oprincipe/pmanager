<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCredit extends Model
{

	protected $fillable = array(
		'company_id',
		'hours',
		'ext_order_id',
		'ext_order_data'
	);


	public function company()
	{
		return $this->belongsTo('App\Company');
	}

}
