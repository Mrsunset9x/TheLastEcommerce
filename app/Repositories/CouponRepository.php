<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Contracts\ICouponRepository;

class CouponRepository extends AbstractRepository implements ICouponRepository
{

    public function getModel()
    {
        return Coupon::class;
    }

    public function getAll($request, $limit = null)
    {
        $query = Coupon::query();
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->where('status', 1)->paginate($limit);
    }

    public function create($attributes, int $id = null)
    {
        return Coupon::updateOrCreate(
        [
            'id'    => $id
        ],
        [
            'coupon_code' => $attributes['coupon_code'],
            'amount'      => $attributes['amount'],
            'amount_type' => $attributes['amount_type'],
            'expiry_date' => $attributes['expiry_date'],
            'status'      => $attributes['status']
        ]);
    }

    public function updateStatus($request, $id = null)
    {
        return Coupon::where('id',$id)->update(['status'=>$request['status']]);
    }
}
