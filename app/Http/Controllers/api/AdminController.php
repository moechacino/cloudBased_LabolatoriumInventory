<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Resources\AdminResource;

use App\Services\AdminService;


use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class AdminController extends Controller
{
    use ApiResponder;
    private AdminService $adminService;

    public  function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function login(AdminLoginRequest $request): JsonResponse
    {
        $response = $this->adminService->login($request);
       return $this->successResponse($response, 200, "OK");
    }

    public function logout(Request $request) : JsonResponse
    {
        $decodedData = $request->decodedData["admin"];
        $id = $decodedData["id"];
        if(empty($id)){
           return $this->errorResponse("id is not set", 400, "BAD_REQUEST");
        }

        $response = $this->adminService->logout($id);

        return $this->successResponse([],200, "OK", [
            "message"=> $decodedData["username"]." logged out"
        ]);
    }
}
