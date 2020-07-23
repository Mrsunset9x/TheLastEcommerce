<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\BannerRequest;
use App\Services\BannerService;
use Intervention\Image\Facades\Image;

// check file tồn tại trong local storate
// xoá update banner
// notify in backend

class BannerController extends Controller
{
    protected $bannerService;
    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse

     */
    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? config('app.paginate.per_page');
            $orderBys = [];
            if ($request->get('column') && $request->get('sort')) {
                $orderBys['column'] = $request->get('column');
                $orderBys['sort'] = $request->get('sort');
            }
            $banner = $this->bannerService->getAll($orderBys,$limit);
             return response()->json([
                 'status' => true,
                 'code'   => Response::HTTP_OK,
                 'banner'  => $banner->items(),
                 'meta'   => [
                     'total'       => $banner->total(),
                     'perPage'     => $banner->perPage(),
                     'currentPage' => $banner->currentPage(),
                 ]
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'errors' =>
                    [
                        'status' => false,
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => $e->getMessage(),
                    ]
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BannerRequest $request)
    {
        try {
            $banner = $this->bannerService->create($request->all());
            return response()->json([
                'status'    => true,
                'banner'    =>$banner,
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'errors' =>
                    [
                        'status' => false,
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => $e->getMessage(),
                    ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $banner = $this->bannerService->find($id);
            return response()->json([
                'status'    => true,
                'banner'    =>$banner,
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'errors' =>
                    [
                        'status' => false,
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => $e->getMessage(),
                    ]
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $banner = $this->bannerService->update($request,$id);

            return response()->json([
                'status'    => true,
                'banner'    =>$banner
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'errors' =>
                    [
                        'status' => false,
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => $e->getMessage(),
                    ]
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
             $this->bannerService->delete($id);

            return response()->json([
                'status'    => true,
                'code'   => Response::HTTP_OK,
            ]);
        }catch (\Exception $e)
        {
            return response()->json([
                'errors' =>
                    [
                        'status' => false,
                        'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                        'message' => $e->getMessage(),
                    ]
            ]);
        }
    }
}
