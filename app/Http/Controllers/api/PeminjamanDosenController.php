<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PeminjamanDosenCreateRequest;
use App\Services\PeminjamanDosenService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeminjamanDosenController extends Controller
{
    use ApiResponder;
    private PeminjamanDosenService $peminjamanDosenService;

    public function __construct(PeminjamanDosenService $peminjamanDosenService){
        $this->peminjamanDosenService = $peminjamanDosenService;
    }
    public function create(PeminjamanDosenCreateRequest $request): JsonResponse
    {
        $response = $this->peminjamanDosenService->create($request);
        return $this->successResponse($response, 201, "CREATED");
    }

    public function getOne($id): JsonResponse
    {
        $response = $this->peminjamanDosenService->getOne((int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function getAll(Request $request): JsonResponse
    {
        $take = (int) $request->query("take", 10);
        $sort = $request->query('sort', 'recent');
        $filter = $request->query('filter', '');
        $response = $this->peminjamanDosenService->getAll($take, $sort, $filter);
        return $this->successResponse($response["data"], 200, 'OK',[
            "page"=>$response["page"]
        ]);
    }

    public function pengembalian($id): JsonResponse
    {
        $response = $this->peminjamanDosenService->pengembalian((int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function delete($id): JsonResponse
    {
        $response = $this->peminjamanDosenService->delete((int) $id);
        return $this->successResponse([], 200, "OK",[
            "message"=>"Peminjaman dengan id ".$id." berhasil dihapus"
        ]);
    }
}
