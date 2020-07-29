<?php
namespace App\Services;
use App\Repositories\Contracts\IImageRepository;
use Illuminate\Http\Request;


class handlingImg
{
    protected $imageRepo;
    public function __construct(IImageRepository $imageRepo)
    {
       $this->imageRepo = $imageRepo;
    }

    public function delete($image)
    {
                if (file_exists(public_path("/uploads/products/".$image))) {
                    unlink(public_path("/uploads/products/".$image));
                }
            return $this->imageRepo->deleteWithName($image);
    }

}
