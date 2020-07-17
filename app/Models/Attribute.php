<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class,'parent_id');
    }
}
