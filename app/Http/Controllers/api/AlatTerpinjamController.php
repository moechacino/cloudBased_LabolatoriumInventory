<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\AlatTerpinjamService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlatTerpinjamController extends Controller
{
    use ApiResponder;
    private AlatTerpinjamService $alatTerpinjamService;

    public function __construct(AlatTerpinjamService $alatTerpinjamService)
    {
        $this->alatTerpinjamService = $alatTerpinjamService;
    }

    public function getAll(Request $request) : JsonResponse
    {
        $take = (int) $request->query("take", 10);
        $sort = $request->query('sort', 'recent');
        $filter = $request->query('filter', '');

        $response = $this->alatTerpinjamService->getAll($take, $sort, $filter);
        return $this->successResponse($response["data"], 200, "OK", [
            "page"=>$response["page"]
        ]);
    }

    public function getOne($id): JsonResponse
    {
        $response = $this->alatTerpinjamService->getOne((int) $id);
        return $this->successResponse($response, 200, "OK");
    }



}
