<?php
namespace App\Repositories;
use App\Models\Image;
class ImageRepository extends AbstractRepository
{
    public function addImg($request)
    {
        return Image::create($request);
    }

    public function getModel()
    {
        return Image::class;
    }
}
