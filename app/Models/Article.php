<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subCategories()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function comments()
    {
        return $this->belongsToMany('App\Models\Comment');
    }
}
