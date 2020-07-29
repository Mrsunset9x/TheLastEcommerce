<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Contracts\IProductRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Repositories\Contracts\IImageRepository;
class ProductService
{
    protected $productRepository;
    protected $imageRepository;

    public function __construct(IProductRepository $productRepository , IImageRepository $imageRepository)
    {
        $this->productRepository = $productRepository;
        $this->imageRepository = $imageRepository;
    }

    public function getAll($orderBy, $limit)
    {
        return $this->productRepository->getAll($orderBy, $limit);
    }

    public function store($request)
    {
//        if (is_file($request['image'])) {
//            $image_tmp = $request['image'];
//            if ($image_tmp->isValid()) {
//                // Upload Images after Resize
//                $extension = $image_tmp->getClientOriginalExtension();
//                $request['image'] = $fileName = rand(111, 99999) . '.' . $extension;
//                $image_path = 'uploads/products/avatar/' . $fileName;
//                Image::make($image_tmp)->resize(150, 150)->save($image_path);
//            }
//        }
        return $this->productRepository->create($request);
    }

    public function update($request,$id)
    {
//        if (!empty($request['image'])) {
//            $products = $this->productRepository->find($id);
//            foreach ($products as $product) {
//                $image_path = "/uploads/products/avatar/" . $product->image;
//                if (file_exists(public_path($image_path))) {
//                    unlink(public_path($image_path));
//                }
//            }
//            $image_tmp = $request['image'];
//            if ($image_tmp->isValid()) {
//                // Upload Images after Resize
//                $extension = $image_tmp->getClientOriginalExtension();
//                $request['image'] = $fileName = rand(111, 99999) . '.' . $extension;
//                $banner_path = 'uploads/products/avatar/' . $fileName;
//                Image::make($image_tmp)->resize(150, 150)->save($banner_path);
//            }
//        }
        return $this->productRepository->create($request, $id);
    }

    public function show($id)
    {
        return $this->productRepository->find($id);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $product = $this->productRepository->find($id);
            foreach ($product as $prd)
            {
                $image_path = "/uploads/products/avatar/" . $prd->image;
                if (file_exists(public_path($image_path))) {
                    unlink(public_path($image_path));
                }
            }
            foreach ($product as $img) {
               foreach ($img->images as $nameImg) {
                   $image_path = "/uploads/products/" . $nameImg->name;
                   if (file_exists(public_path($image_path))) {
                       unlink(public_path($image_path));
                   }
                   $this->imageRepository->delete($nameImg->id);
               }
            }
            DB::commit();
            return $this->productRepository->delete($id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'errors' =>
                    [
                        'status' => false,
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => $e->getMessage(),
                    ]
            ]);
        }
    }

    public function addImg($request, $id)
    {
        $product = Product::find($id);
        foreach ($request as $img) {
            $image = [];
            $image['product_id'] = $product->id;
            $extension = $img->getClientOriginalExtension();
            $image['name'] = $fileName = rand(111, 99999) . '.' . $extension;
            $image_path = 'uploads/products/' . $fileName;
            Image::make($img)->resize(700, 700)->save($image_path);
            $this->imageRepository->create($image);
        }
        return $this->productRepository->showProductWithImg($id);
    }


}
