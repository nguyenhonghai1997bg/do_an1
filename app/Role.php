<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const PERPAGE = 15;
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * relationship to users table
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
