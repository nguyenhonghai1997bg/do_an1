<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const PERPAGE = 15;
    protected $guarded = ['id'];

    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }

    public function sale()
    {
        return $this->belongsTo('App\Sale');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
