<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService ;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? config('app.paginate.per_page');
            $orderBys = [];
            if ($request->get('column') && $request->get('sort')) {
                $orderBys['column'] = $request->get('column');
                $orderBys['sort'] = $request->get('sort');
            }
            $order = $this->orderService->getAll($orderBys, $limit);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
                'order'  => $order->items(),
                'meta'   => [
                    'total'       => $order->total(),
                    'perPage'     => $order->perPage(),
                    'currentPage' => $order->currentPage(),
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

    public function deliverOrder(Order $order)
    {
        try {
            $order->order_status = 1;
            $id = $order->id;
            $status = $order->save();
            $a = Order::join('order_product','orders.id','order_product.order_id')
                ->where('order_product.order_id',$id)
                ->select('order_product.product_id','order_product.quantity')->first();
            $products = Product::findOrFail($a->product_id);
            $products->units = $products->units - $a->quantity;

            return response()->json([
                'status'    => $status,
                'data'      => $order,
                'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = [];

        $data['user_id'] = Auth::guard()->user()->id;
        if(!empty($request->coupon))
        {
            $coupon = Coupon::where('coupon_code',$request->coupon)->first();
            if ($coupon){
            $data['coupon_id'] = $coupon->id;
            }
        }
        $data['name'] = $request->name;
        $data['mobile'] = $request->mobile;
        $data['address'] = $request->address;
        $data['shipping_charges'] = $request->shipping_charges;
        $order = Order::create($data);
        $order_id = $order->id;
        //
        $a = Product::where('id',$request->product_id)->first();
        $price = $a->price;
        //
        $orderdetails = OrderProduct::create([
            'order_id' => $order_id,
            'user_id' => Auth::guard()->user()->id,
            'product_id'=>$request->product_id,
            'price' =>$price * $request->quantity,
            'quantity' =>$request->quantity,
        ]);

        return response()->json([
            'status'    => true,
            'orderDetail' => $orderdetails
        ]);
    }

    public function ChangeCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_code',$request->coupon)->first();
        $amount = $coupon->amount;
        $code   = $coupon->coupon_code;
        return response()->json([
            'status'    => true,
            'amount' => $amount,
            'code'     =>$code
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
