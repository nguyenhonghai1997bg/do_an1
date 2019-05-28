<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const PERPAGE = 15;
    const WAITING = 0;
    const PROCESS = 1;
    const DONE = 2;
    const PAYMENTED = 1;
    protected $guarded = ['id'];

    public function detailOrders()
    {
        return $this->hasMany('App\DetailOrder');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function paymethod()
    {
        return $this->belongsTo('App\Paymethod');
    }

    public function scopeIsDeleted($query)
    {
        $query->whereNotNull('deleted_at');
    }

    public function scopeIsNotDelete($query)
    {
        $query->whereNull('deleted_at');
    }
}
