<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\IProductRepository;

class ProductRepository extends AbstractRepository implements IProductRepository
{
    public function getModel()
    {
       return Product::class;
    }

    public function getAll($request, $limit = null)
    {
        $query = Product::query()->with('images');
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->where('status', 1)->paginate($limit);
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
            'sku'            => $attributes['sku'],
            'color'          => $attributes['color'],
            'description'    => $attributes['description'],
            'price'          => $attributes['price'],
            'status'         => $attributes['status'],
            'featured_products' => $attributes['featured_products'],
            'image'          => $attributes['image']
        ]);
    }
    public function find($id)
    {
        return Product::find($id)->with('images')->get();

    }


}
