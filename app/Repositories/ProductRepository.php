<?php
namespace App\Repositories;

use App\Models\Attribute;
use App\Models\Product;
use App\Repositories\Contracts\IProductRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository extends AbstractRepository implements IProductRepository
{
    public function getModel()
    {
       return Product::class;
    }

    public function getAll($request, $limit = null)
    {
        $query = Product::query()->with('attributes','images');
        if ($query) {
            $query->join('categories','products.category_id','categories.id')
            ->select('products.*','categories.name as Catname')
            ->orderBy($request['column'], $request['sort']);
        }

        return $query->paginate($limit);
    }

    public function  create($attributes, int $id = null)
    {
        return Product::updateOrCreate(
        [
            'id' => $id
        ],
        [
            'category_id'    =>$attributes['category_id'],
            'name'           => $attributes['name'],
            'description'    => $attributes['description'],
            'price'          => $attributes['price'],
            'units'          => $attributes['units'],
            'image'          => $attributes['image'],
            'status'         => $attributes['status'],
        ]);
    }
    public function find($id)
   {
       return Product::where('id',$id)->with('attributes','images')->get();
   }

   public function delete($id)
  {
       return Product::where('id',$id)->with('images')->delete($id);
   }

    public function addImg($img)
   {
        return Attribute::create([
           'name'       =>$img['name'],
        ]);
   }
    public function showProductWithImg($id)
    {
        return Product::where('id',$id)->with('images')->get();
    }

}
