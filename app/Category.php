<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const PERPAGE = 15;
    protected $fillable = [
        'name',
        'slug',
        'catalog_id'
    ];

    /**
     * relationship to catalogs table
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalog()
    {
        return $this->belongsTo('App\Catalog');
    }
}
