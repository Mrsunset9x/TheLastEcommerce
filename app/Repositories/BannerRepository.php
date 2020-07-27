<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Repositories\Contracts\IBannerRepository;


class BannerRepository extends AbstractRepository implements IBannerRepository
{
    public function getModel()
    {
        return Banner::class;
    }

    public function create($request, int $id = null)
    {
        return Banner::updateOrCreate(
            [
                'id' => $id
            ],
            [
                'name' => $request['name'],
                'content' => $request['content'],
                'link' => $request['link'],
                'status' => $request['status'],
                'images' => $request['image']
            ]);
    }

    public function getAll($request, $limit = null)
    {
        $query = Banner::query();
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->paginate($limit);
    }



}
