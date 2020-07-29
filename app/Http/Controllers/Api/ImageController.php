<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\handlingImg;

class ImageController extends Controller
{
    protected $handleImg;
    public function __construct(handlingImg $handleImg)
    {
        $this->handleImg =$handleImg;
    }

    public function deleteImg(Request $request)
    {
        try {
            $this->handleImg->delete($request->images);
            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
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
}
