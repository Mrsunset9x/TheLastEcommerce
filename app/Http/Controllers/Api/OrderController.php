<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
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
                'order'  => $order,
//                'meta'   => [
//                    'total'       => $order->total(),
//                    'perPage'     => $order->perPage(),
//                    'currentPage' => $order->currentPage(),
//                ]
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
        $order->order_status =1;
        $status = $order->save();

        return response()->json([
            'status'    => $status,
            'data'      => $order,
            'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
        ]);
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
        if(!empty($request->coupon_id))
        {
            $coupon_id = Coupon::where('coupon_code',$request->coupon_id)->first();
            $data['coupon_id'] = $coupon_id->id;
        }
        $data['name'] = $request->name;
        $data['mobile'] = $request->mobile;
        $data['address'] = $request->address;
        $data['shipping_charges'] = $request->shipping_charges;
        $order = Order::create($data);
        $order_id = $order->id;

        $orderdetails = OrderProduct::create([
            'order_id' => $order_id,
            'user_id' => Auth::guard()->user()->id,
            'product_id'=>$request->product_id,
            'quantity' =>$request->quantity,
        ]);
//        foreach (Cart::content() as $key => $cart) {
//            $orderdetail['order_id'] = $order_id;
//            $orderdetail['user_id'] = Auth::guard()->user()->id;
//            $orderdetail['product_id'] = $cart->id;
//            $orderdetail['product_price'] = $cart->price;
//            $orderdetail['quantity'] = $cart->qty;
//            $orderdetails[$key] = OrderProduct::create($orderdetail);
//        }

        return response()->json([
            'status'    => true,
            'orderDetail' => $orderdetails
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
