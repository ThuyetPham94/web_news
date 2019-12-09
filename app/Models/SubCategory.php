<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    /**
     * Get the sub category that owns the category.
     */
    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }
}
