<?php

namespace App\Repositories;
use App\Models\Banner;
use App\Repositories\Contracts\IBannerRepository;



class BannerRepository extends AbstractRepository implements IBannerRepository
{
    public function getModel()
    {
       return Banner::class;
    }

    public function create( $request ,int $id=null)
    {
       return Banner::updateOrCreate(
       [
               'id' => $id
       ],
       [
          'name'  => $request['name'],
          'text_style'  => $request['text_style'],
          'sort_order'  => $request['sort_order'],
          'content'  => $request['content'],
          'link'  => $request['link'],
          'status'  => $request['status'],
           'images'  => $request['image']
       ]);

    }

    public function getAll($request ,$limit = null)
    {
        $query = Banner::query();
        if ($query) {
            $query->orderBy($request['column'], $request['sort']);
        }
        return $query->where('status', 1)->paginate($limit);
    }

    public function update($id, array $attributes)
    {
        return Banner::where('id',$id)->update([
            'name'=>$attributes['banner_name'],
            'text_style'=>$attributes['text_style'],
            'content'=>$attributes['banner_content'],
            'link'=>$attributes['link'],
            'sort_order'=>$attributes['sort_order'],
            'image'=>$attributes['image']
        ]);
    }

}
