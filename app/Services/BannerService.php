<?php

namespace App\Services;


use App\Repositories\Contracts\IBannerRepository;
use Intervention\Image\Facades\Image;

class BannerService
{
    protected $bannerRepository;
    protected $imageService;

    public function __construct(IBannerRepository $bannerRepository ,  ImageService $imageService)
    {
        $this->bannerRepository = $bannerRepository;
        $this->imageService     = $imageService;
    }

    public function create($request, int $id = null)
    {
        $banner = [];
        $banner['name'] = $request['name'];
        $banner['content'] = $request['content'];
        $banner['link'] = $request['link'];
        $banner['status'] = $request['status'];
        // Upload Image
        $banner['images'] = $request['images'];
        return $this->bannerRepository->create($banner);
    }

    public function getAll($request ,$limit =null)
    {
        return $this->bannerRepository->getAll($request,$limit);
    }

    public function find($id)
    {
        return $this->bannerRepository->find($id);
    }

    public function update($data ,$id)
    {
        return $this->bannerRepository->create($data,$id);
    }

    public function delete($id)
    {
        $banner = $this->bannerRepository->find($id);
        if(!empty($banner->images))
        {
            if (file_exists(public_path('uploads/banners/'.$banner->images)))
            {
                unlink(public_path('uploads/banners/'.$banner->images));
            }
        }
        return $this->bannerRepository->delete($id);
    }

    public function updateImage($img)
    {
        if (is_file($img))
        {
            $extension = $img->getClientOriginalExtension();
            $fileName = rand(111, 99999) . '.' . $extension;
            $banner_path = 'uploads/banners/' . $fileName;
            Image::make($img)->save($banner_path);
            return $fileName;
        }else {
            return $fileName = '';
        }
    }
}
