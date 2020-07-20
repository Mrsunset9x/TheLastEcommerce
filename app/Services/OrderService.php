<?php
namespace App\Services;
use App\Repositories\Contracts\IOrderRepository;
class OrderService
{
    protected $iorderRepository;
    public function __construct(IOrderRepository $iorderRepository)
    {
        $this->iorderRepository =$iorderRepository;
    }

    public function getAll($orderBy , $limit)
    {
        return  $this->iorderRepository->getAll($orderBy,$limit);

    }
}
