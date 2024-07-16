<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PeminjamanMahasiswaCreateRequest;
use App\Services\PeminjamanMahasiswaService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PeminjamanMahasiswaController extends Controller
{
    use ApiResponder;

    private PeminjamanMahasiswaService $peminjamanMahasiswaService;

    public function __construct(PeminjamanMahasiswaService $peminjamanMahasiswaService){
        $this->peminjamanMahasiswaService = $peminjamanMahasiswaService;
    }
    public function create(PeminjamanMahasiswaCreateRequest $request): JsonResponse
    {
        $response = $this->peminjamanMahasiswaService->create($request);
        return $this->successResponse($response, 201, "CREATED");
    }

    public function getOne($id): JsonResponse
    {
        $response = $this->peminjamanMahasiswaService->getOne((int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function getAll(Request $request): JsonResponse
    {
        $take = (int) $request->query("take", 10);
        $sort = $request->query('sort', 'recent');
        $filter = $request->query('filter', '');
        $status = $request->query('status' , '');
        $response = $this->peminjamanMahasiswaService->getAll($take, $sort, $filter, $status);
        return $this->successResponse($response["data"], 200, 'OK',[
            "page"=>$response["page"]
        ]);
    }
    public function accept($id): JsonResponse
    {
        $response = $this->peminjamanMahasiswaService->accept((int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function reject($id): JsonResponse
    {
        $response = $this->peminjamanMahasiswaService->reject((int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function pengembalian($id): JsonResponse
    {
        $response = $this->peminjamanMahasiswaService->pengembalian((int) $id);
        return $this->successResponse($response, 200, "OK");
    }

    public function delete($id): JsonResponse
    {
        $response = $this->peminjamanMahasiswaService->delete((int) $id);
        return $this->successResponse([], 200, "OK",[
            "message"=>"Peminjaman dengan id ".$id." berhasil dihapus"
        ]);
    }
}
