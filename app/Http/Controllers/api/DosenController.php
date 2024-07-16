<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DosenCreateRequest;
use App\Services\DosenService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    use ApiResponder;

    private DosenService $dosenService;

    public function __construct(DosenService $dosenService)
    {
        $this->dosenService = $dosenService;
    }

    public function create(DosenCreateRequest $request): JsonResponse
    {
        $response = $this->dosenService->create($request);
        return $this->successResponse($response, 201, "CREATED");
    }

    public function getOneByRfid($rfid_uid): JsonResponse
    {
        $response = $this->dosenService->getOneByRfid((string) $rfid_uid);
        return $this->successResponse($response, 200, "OK");
    }

    public function getOneById($id) : JsonResponse
    {
        $response = $this->dosenService->getOneById((int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function getAll(Request $request): JsonResponse
    {
        $take = (int) $request->query("take", 10);
        $sort = $request->query('sort', 'recent');
        $search = $request->query('search', '');

        $response = $this->dosenService->getAll($take, $sort, $search);
        return $this->successResponse($response["data"], 200, "OK", [
            "page"=> $response["page"]
        ]);
    }

    public function edit(DosenCreateRequest $request, $id): JsonResponse
    {
        $response = $this->dosenService->edit($request, (int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function delete($id): JsonResponse
    {
        $response = $this->dosenService->delete((int) $id);
        return $this->successResponse([], 200, "OK", [
            "message"=> "Dosen with id ".$id." berhasil dihapus"
        ]);
    }


}
