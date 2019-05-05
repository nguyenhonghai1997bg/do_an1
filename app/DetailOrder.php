<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
	const PERPAGE = 15;
    protected $guarded = ['id'];

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }

    public function order()
    {
    	return $this->belongsTo('App\Order');
    }

}
