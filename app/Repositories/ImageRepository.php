<?php
namespace App\Repositories;
use App\Models\Image;
use App\Repositories\Contracts\IImageRepository;

class ImageRepository extends AbstractRepository implements IImageRepository
{

    public function getModel()
    {
        return Image::class;
    }

    public function  delete($id)
    {
        return Image::destroy($id);
    }

    public function create($attributes, int $id = null)
    {
        return Image::updateOrCreate([
            'id' => $id
        ],
        [
            'product_id' => $attributes['product_id'],
            'name'       => $attributes['name']
        ]);
    }

    public function deleteWithName($name)
    {
        return Image::where('name',$name)->delete($name);
    }
}
