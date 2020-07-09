<?php

namespace App\Services;

use App\Repositories\CouponRepository;

class CouponService
{
    protected $couponRepository;
    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    public function getAll($orderBy , $limit)
    {
        return $this->couponRepository->getAll($orderBy,$limit);
    }

}
