<?php
namespace App\Repositories\Contracts;

interface BaseRepository
{
    public function create($attributes,int $id =null);
    public function update($id,array $attributes);
    public function find($id);
    public function delete($id);

}
