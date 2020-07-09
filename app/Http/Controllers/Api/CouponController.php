<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;

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
            $category = $this->couponService->getAll($orderBys,$limit);
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
}
