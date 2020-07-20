<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    public function orderProducts(){
        return $this->hasMany('App\Models\OrderProduct','order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
