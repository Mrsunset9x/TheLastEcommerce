<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\ICategoryRepository;

class CategoryRepository extends AbstractRepository implements ICategoryRepository
{

    public function getModel()
    {
        return Category::class;
    }

    public function getAll($request, $limit = null)
    {
//        $query = Category::query()->with('categories');
//        if ($query) {
//            $query->orderBy($request['column'], $request['sort']);
//        }
//        return $query->where('parent_id', 0)->paginate($limit);
        return Category::with('categories')
            ->where('parent_id',0)
            ->get()->toArray();
    }

    public function create($attributes, int $id = null)
    {
        return Category::updateOrCreate(
            [
                'id' => $id
            ],
            [
                'parent_id' => $attributes['parent_id'],
                'name'     => $attributes['name'],
                'url'     => utf8tourl($attributes['name']),
                'description' => $attributes['description'],
                'status' => $attributes['status']
            ]
        );
    }

}
