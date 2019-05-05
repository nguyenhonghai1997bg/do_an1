<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    const PERPAGE = 4;
    protected $fillable = [
        'content',
        'product_id',
        'user_id',
        'rating',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($date)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i');
    }
}
