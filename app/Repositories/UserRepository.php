<?php
namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Repositories\Contracts\IUserRepository;

class UserRepository extends AbstractRepository implements IUserRepository
{
    function getModel()
    {
       return User::class;
    }

    public function getAll($request, $limit = null)
    {
        $query = User::query()->with('orders');
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->paginate($limit);
    }

    public function getOrder($userId)
    {
       return $userId->orders()->with(['products'])->get();
    }
}
