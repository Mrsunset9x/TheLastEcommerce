<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class CouponController extends Controller
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService =$couponService;
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
            $coupon = $this->couponService->getAll($orderBys,$limit);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
                'coupon'  => $coupon->items(),
                'meta'   => [
                    'total'       => $coupon->total(),
                    'perPage'     => $coupon->perPage(),
                    'currentPage' => $coupon->currentPage(),
                ]
            ]);
        }catch (\Exception $e)
        {
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

    public function store(Request $request)
    {
        try {
            $coupon =  $this->couponService->create($request->all());
            return response()->json([
                'status'  => true,
                'coupon'  => $coupon,
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'status'    =>false,
                'code'      => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message'   => $e->getMessage()
            ]);
        }
    }


    public function show($id)
    {
        try {
            $category = $this->couponService->find($id);
            return response()->json([
                'status'    => true,
                'coupon'    =>$category
            ]);
        }catch (\Exception $e)
        {
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

    public function update(Request $request , $id)
    {
        try {
            $category = $this->couponService->create($request, $id);
            return response()->json([
                'status'    => true,
                'category'    =>$category
            ]);
        }catch (\Exception $e)
        {
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
            $this->couponService->delete($id);
            return response()->json([
                'status'    => true,
                'code'   => Response::HTTP_OK,
            ]);
        }catch (\Exception $e)
        {
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
}
