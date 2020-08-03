<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    protected $reportService;
    public function __construct(ReportService $reportService)
    {
        $this->reportService =$reportService;
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
            $report = $this->reportService->getAll($orderBys, $limit);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
                'ReportUser'  => $report->items(),
                'meta'   => [
                    'total'       => $report->total(),
                    'perPage'     => $report->perPage(),
                    'currentPage' => $report->currentPage(),
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
    public function show($id)
    {
        try {
            $report = $this->reportService->getReportOfProduct($id);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
                'report' =>$report

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

    public function store(Request $request,$id)
    {
        try {
            $report = $this->reportService->storeReport($request , $id);
            return response()->json([
                'status' => true,
                'code'   => Response::HTTP_OK,
                'report' =>$report

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
