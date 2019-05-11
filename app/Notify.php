<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
	const PERPAGE = 6;
	const PERPAGE_ALL = 15;
    protected $guarded = ['id'];
}
