<?php
namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\IOrderRepository;

class OrderRepository extends AbstractRepository implements IOrderRepository
{

    public function getModel()
    {
        return Order::class;
    }

    public function getAll($request, $limit = null)
    {   $query = Order::query()->with('products');
        $query->join('order_product','order_product.order_id','orders.id')
            ->select('orders.*','order_product.*');
        return $query->get();
    }
}
