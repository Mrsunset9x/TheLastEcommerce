<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::guard()->user()->id;
        if(!empty($request->coupon_id))
        {
           $coupon_id = Coupon::where('coupon_code',$request->coupon_id)->first();
            $data['coupon_id'] = $coupon_id->id;
        }
        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['mobile'] = $request->mobile;
        $order = Order::create($data);
        $order_id = $order->id;
        $orderdetail = [];
        $orderdetails = [];

        foreach (Cart::content() as $key => $cart) {
            $orderdetail['order_id'] = $order_id;
            $orderdetail['user_id'] = Auth::guard()->user()->id;
            $orderdetail['product_id'] = $cart->id;
            $orderdetail['product_price'] = $cart->price;
            $orderdetail['quantity'] = $cart->qty;
            $orderdetails[$key] = OrderProduct::create($orderdetail);
        }

        return response()->json([
            'status'    => true,
            'orderDetail' => $orderdetails
        ]);
    }

    public function destroy(Request $request)
    {
      foreach (Cart::content() as $content){
        Cart::remove($content->rowId);

      }
        return response()->json([
            'result' =>'Đã xoá thành công'
        ]);
    }

    public function addProductToCart(Request $request,$id)
    {
        try {
            $product = Product::find($id);
            if ($request->qty) {
                $qty = $request->qty;
            } else {
                $qty = 1;
            }
            Cart::add([
                'id' =>$id,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $product->price,
                'options' => ['size' => $request->size,'color'=>$request->color],
                'weight' => 130 //Product không có weight nhưng chưa tìm cách bỏ được vì format của shoppingcart pakage này yêu cầu có weight
            ]);

            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'InsideCart' =>Cart::content(),
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
