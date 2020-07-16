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
    {
        $query = Order::query();
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->paginate($limit);
    }
}
