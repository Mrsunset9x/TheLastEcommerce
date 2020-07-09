<?php

namespace App\Repositories\Contracts;

interface IBannerRepository
{
    public function getModel();

    public function create($request, int $id = null);

    public function getAll($request, $limit = null);

    public function find($id);

    public function delete($id);

    public function update($id, array $attributes);
}
