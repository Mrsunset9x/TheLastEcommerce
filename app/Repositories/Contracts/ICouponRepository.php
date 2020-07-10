<?php
namespace App\Repositories\Contracts;

interface ICouponRepository
{
    public function updateStatus($request,$id=null);
}
