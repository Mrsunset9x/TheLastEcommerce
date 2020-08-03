<?php
namespace App\Repositories;


use App\Models\Product;
use App\Models\UserReport;
use App\Repositories\Contracts\IReportUserRepository;

class ReportUserRepository extends AbstractRepository implements IReportUserRepository
{

    public function getModel()
    {
        return UserReport::class;
    }

    public function getAll($request, $limit = null)
    {
        $query = UserReport::query()->with('product');
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->paginate($limit);
    }

    public function getReportOfPrd($id)
    {
       return UserReport::join('users','users.id','user_reports.user_id')
           ->where('user_reports.product_id',$id)
           ->select('users.*','user_reports.*')
           ->get();
    }

    public function create($request, int $id = null)
    {
        return UserReport::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'product_id'    =>$id,
                'vote'      =>$request['vote'],
                'content'   =>$request['content']
            ]);
    }
}
