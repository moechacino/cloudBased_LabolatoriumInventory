<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MahasiswaCreateRequest;
use App\Services\MahasiswaService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    use ApiResponder;
    private MahasiswaService $mahasiswaService;

    public  function __construct(MahasiswaService $mahasiswaService)
    {
        $this->mahasiswaService = $mahasiswaService;
    }

    public  function create(MahasiswaCreateRequest $request): JsonResponse
    {
        $response = $this->mahasiswaService->create($request);

        return  $this->successResponse($response, 201, "CREATED");
    }

    public  function getOneByRfid($rfid_uid) : JsonResponse
    {
        $response = $this->mahasiswaService->getOneByRfid((string) $rfid_uid);
        return $this->successResponse($response, 200, 'OK');
    }

    public function getOneById($id) : JsonResponse
    {
        $response = $this->mahasiswaService->getOneById((int) $id);
        return $this->successResponse($response, 200, 'OK');
    }

    public function getAll(Request $request) : JsonResponse
    {
        $take = (int) $request->query("take", 10);
        $sort = $request->query('sort', 'recent');
        $search = $request->query('search', '');

        $response = $this->mahasiswaService->getAll($take, $sort, $search);
        return  $this->successResponse($response["data"], 200, 'OK',[
           "page"=>$response["page"]
        ]);
    }

    public function edit(MahasiswaCreateRequest $request, $id): JsonResponse
    {
        $response = $this->mahasiswaService->edit($request,(int)$id );
        return $this->successResponse($response, 200, "OK");
    }

    public function delete($id) : JsonResponse
    {
        $response = $this->mahasiswaService->delete((int)$id);
        return  $this->successResponse([],200,'OK',[
            "message"=> "mahasiswa with id " . $id . " has been deleted"
        ]);
    }
}
