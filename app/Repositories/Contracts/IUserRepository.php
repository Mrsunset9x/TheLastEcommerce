<?php
namespace App\Repositories\Contracts;

interface IUserRepository
{
    public function getOrder($userId);
}
