<?php
namespace App\Repositories\Contracts;

interface IProductRepository
{
    public function addImg($img );
    public function showProductWithImg($id);
}
