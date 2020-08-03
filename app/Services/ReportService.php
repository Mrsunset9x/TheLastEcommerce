<?php
namespace App\Services;


use App\Repositories\Contracts\IReportUserRepository;

class ReportService
{
    protected $ireportUserRepository;
    public function __construct(IReportUserRepository $ireportUserRepository)
    {
        $this->ireportUserRepository =$ireportUserRepository;
    }

    public function getAll($orderBy, $limit)
    {
        return $this->ireportUserRepository->getAll($orderBy, $limit);
    }

    public function getReportOfProduct($id)
    {
        return $this->ireportUserRepository->getReportOfPrd($id);
    }

    public function storeReport($request , $id)
    {
        return $this->ireportUserRepository->create($request,$id);
    }

}
