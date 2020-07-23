<?php
namespace App\Services;

use App\Repositories\Contracts\IUserRepository;
use Illuminate\Http\Response;

class UserService
{
    protected $iuserRepository;
    public function __construct(IUserRepository $iuserRepository)
    {
        return $this->iuserRepository = $iuserRepository;
    }

    public function getAll($orderBy, $limit)
    {
        return $this->iuserRepository->getAll($orderBy, $limit);
    }

    public function delete($id)
    {
        return $this->iuserRepository->delete($id);
    }

}
