<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
class Product extends Model
{

    protected $table = 'products';
   protected $fillable = [
       'category_id',
       'name','sku','color','description','price','status','featured_products'
   ];


    public function attributes(){
        return $this->hasMany('App\Models\ProductAttribute','product_id');
    }
    public function images()
    {
        return $this->hasMany('App\Models\Image', 'product_id','id');
    }
}
