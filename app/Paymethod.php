<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymethod extends Model
{
    const PERPAGE = 15;
    protected $fillable = [
        'name',
        'slug'
    ];
}
