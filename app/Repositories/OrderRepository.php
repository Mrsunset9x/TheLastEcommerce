<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Repositories\Contracts\IOrderRepository;

class OrderRepository extends AbstractRepository implements IOrderRepository
{

    public function getModel()
    {
        return Order::class;
    }

    public function getAll($request, $limit = null)
    {
//        $query = Order::query()->whereHas('products');
//        $query->join('order_product','order_product.order_id','orders.id')
//            ->select('orders.*','order_product.*');
//        return $query->get();
       return OrderProduct::join('products','products.id','order_product.product_id')
           ->join('orders','orders.id','order_product.order_id')
           ->select('orders.id as ordId','orders.name as usrName','orders.address as usrAddress','orders.order_status as ordStt','products.*','order_product.quantity')
           ->get();
    }
}
