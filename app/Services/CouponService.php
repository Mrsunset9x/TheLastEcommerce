<?php

namespace App\Services;

use App\Repositories\Contracts\ICouponRepository;


class CouponService
{
    protected $couponRepository;
    public function __construct(ICouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function getAll($orderBy , $limit)
    {
        return $this->couponRepository->getAll($orderBy,$limit);
    }

    public function create($request, $id =null)
    {
        return $this->couponRepository->create($request, $id);
    }


    public function find($id)
    {
        return $this->couponRepository->find($id);
    }

    public function delete($id)
    {
        return $this->couponRepository->delete($id);
    }



}
