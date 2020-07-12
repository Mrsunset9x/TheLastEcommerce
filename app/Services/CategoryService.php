<?php

namespace App\Services;

use App\Repositories\Contracts\ICategoryRepository;

class CategoryService
{
    protected $categoryRepository;
    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll($request ,$limit =null)
    {
        return $this->categoryRepository->getAll($request,$limit);
    }

    public function create($request , int $id = null)
    {
        return $this->categoryRepository->create($request,$id);
    }

    public function show($id)
    {
        return $this->categoryRepository->find($id);
    }

    public function update($request , $id)
    {
        return $this->categoryRepository->create($request,$id);
    }

    public function delete($id)
    {
        return $this->categoryRepository->delete($id);
    }

}
