<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? config('app.paginate.per_page');
            $orderBys = [];
            if ($request->get('column') && $request->get('sort')) {
                $orderBys['column'] = $request->get('column');
                $orderBys['sort'] = $request->get('sort');
            }
            $product = $this->productService->getAll($orderBys, $limit);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
                'product'  => $product->items(),
                'meta'   => [
                    'total'       => $product->total(),
                    'perPage'     => $product->perPage(),
                    'currentPage' => $product->currentPage(),
                ]
            ]);
        } catch (\Exception $e) {
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

    public function show($id)
    {
        try {
            $product = $this->productService->show($id);
            return response()->json([
                'status' => true,
                'product' => $product
            ]);
        } catch (\Exception $e) {
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

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->store($request->all());
            return response()->json([
                'status' => true,
                'product' => $product
            ]);
        } catch (\Exception $e) {
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

    public function update(Request $request, $id)
    {
        try {
            $product = $this->productService->update($request->all() ,$id);
            return response()->json([
                'status' => true,
                'product' => $product
            ]);
        } catch (\Exception $e) {
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

    public function destroy($id)
    {
        try {
            $this->productService->delete($id);
            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
            ]);
        } catch (\Exception $e) {
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

    public function addMoreImgToProduct(Request $request, $id)
    {
        try {
            $product = $this->productService->addImg($request->images, $id);
            return response()->json([
                'status' => true,
                'images' => $product
            ]);
        } catch (\Exception $e) {
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

    public function uploadFile(Request $request)
    {
        if (is_file($request->image)) {
            $image_tmp = $request->image;
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                 $fileName = $request->image = rand(111, 99999) . '.' . $extension;
                $image_path = 'uploads/products/avatar/' . $fileName;
                Image::make($image_tmp)->resize(300, 300)->save($image_path);
            }
            return $fileName;
        }
    }

}
