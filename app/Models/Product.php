<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $table = 'products';
   protected $guarded = [];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\Image::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function reports()
    {
        return $this->hasMany(UserReport::class);
    }
}
