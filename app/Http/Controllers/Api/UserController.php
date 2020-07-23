<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected $userService;
    public function __construct(UserService $userService)
    {
        return $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? config('app.paginate.per_page');
            $orderBys = [];
            if ($request->get('column') && $request->get('sort')) {
                $orderBys['column'] = $request->get('column');
                $orderBys['sort'] = $request->get('sort');
            }
            $user = $this->userService->getAll($orderBys, $limit);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
                'users'  => $user->items(),
                'meta'   => [
                    'total'       => $user->total(),
                    'perPage'     => $user->perPage(),
                    'currentPage' => $user->currentPage(),
                ]
            ]);
        } catch (\Exception $e) {
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $a = User::find($id)->created_at;
       return $a->toDateString();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            $this->userService->delete($id);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
            ]);
        } catch (\Exception $e) {
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

    public function acceptUser(User $user)
    {
        $user->status =1;
        $status = $user->save();

        return response()->json([
            'status'    => $status,
            'data'      => $user,
            'message'   => $status ? '$user Delivered!' : 'Error accept $user'
        ]);
    }
}
