<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    const PERPAGE = 15;
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * relationship to categories table
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function categories()
    {
        return $this->hasMany('App\Category');
    }
}
