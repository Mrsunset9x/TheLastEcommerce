<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends AbstractRepository
{

    public function getModel()
    {
        return Category::class;
    }

    public function getAll($request, $limit = null)
    {
        $query = Category::query();
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->where('status', 1)->paginate($limit);
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

    public function find($id)
    {
        return Category::find($id);
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }
}
