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
        $banner['text_style'] = $request['text_style'];
        $banner['sort_order'] = $request['sort_order'];
        $banner['content'] = $request['content'];
        $banner['link'] = $request['link'];
        $banner['status'] = $request['status'];
        // Upload Image
        if (is_file($request['image'])) {
            $image_tmp = $request['image'];
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111, 99999) . '.' . $extension;
                $banner_path = 'uploads/banners/' . $fileName;
                Image::make($image_tmp)->save($banner_path);
            }
        }
        $banner['image'] = $fileName;
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
       $banner = $this->bannerRepository->find($id);
       if(!empty($banner->images))
       {
           $img = 'uploads/banners/' . $banner->images;
           if ($img !=null) {
               unlink(public_path('uploads/banners/' .$banner->images));
           }else
           {
               return false;
           }
       }
        if (is_file($data['image'])) {
            $image_tmp = $data['image'];
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111, 99999) . '.' . $extension;
                $banner_path = 'uploads/banners/' . $fileName;
                Image::make($image_tmp)->save($banner_path);
            }
        }
        $banner['image'] = $fileName;
        return $this->bannerRepository->update($id,$banner);
    }

    public function delete($id)
    {
        $banner = $this->bannerRepository->find($id);
        if(!empty($banner->images))
        {
            $img = 'uploads/banners/'.$banner->images;
            if (!empty(public_path('uploads/banners/'.$banner->images)))
            {
                unlink(public_path('uploads/banners/'.$banner->images));
            }else
            {
                return false;
            }
        }
        return $this->bannerRepository->delete($id);
    }
}
