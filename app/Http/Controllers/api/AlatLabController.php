<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlatLabCreateRequest;

use App\Services\AlatLabService;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlatLabController extends Controller
{
    use ApiResponder;
    private AlatLabService $alatLabService;

    public  function __construct(AlatLabService $alatLabService)
    {
        $this->alatLabService = $alatLabService;
    }

   public function create(AlatLabCreateRequest $request): JsonResponse
    {
        $response = $this->alatLabService->create($request);
       return $this->successResponse($response, 201, "CREATED");
    }

    public function delete( $id): JsonResponse
    {
       $response = $this->alatLabService->delete((int) $id);
        return  $this->successResponse([],200,'OK',[
            "message"=> "data with id " . $id . " has been deleted"
        ]);
    }

    public function edit(AlatLabCreateRequest $request, $id): JsonResponse
    {

        $response = $this->alatLabService->edit($request,(int) $id);

        return  $this->successResponse($response, 200, "OK");
    }

   public function getOne( $id):JsonResponse
    {
        $response = $this->alatLabService->getOne($id);
        return  $this->successResponse($response, 200, "OK");
    }

    public function getOneByRfid($rfid_uid): JsonResponse
    {
        $response = $this->alatLabService->getOneByRfid((string) $rfid_uid);
        return  $this->successResponse($response, 200, "OK");
    }

   public function getAll(Request $request): JsonResponse
    {
       $take = (int) $request->query("take", 10);
        $sort = $request->query('sort', 'recent');
        $search = $request->query('search', '');

        $response = $this->alatLabService->getAll($take, $sort, $search);

        return $this->successResponse($response["data"], 200,"OK",[
            "page"=>[
                $response["page"]
            ]
        ]);
    }
}
