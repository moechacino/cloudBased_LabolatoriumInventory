<?php

namespace App\Services\Impl;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Services\AdminService;
use App\Traits\ApiResponder;
use Firebase\JWT\JWT;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class AdminServiceImpl implements AdminService
{
    use ApiResponder;

    function login(AdminLoginRequest $request): AdminResource
    {
        $data = $request->validated();
        $admin = Admin::query()->where("username",$data["username"])->first();

        if (!$admin ||$data["password"] !== $admin->password) {
            $this->throwResponse("username or password is wrong", 401, "UNAUTHORIZED");
        }

        $JWT_SECRET = env("JWT_SECRET");
        $JWT_ALGORITHM =  env('JWT_ALGORITHM');
        try {
            $token = JWT::encode([
                "id"=> $admin->id,
                "username"=> $admin->username,
                "name"=> $admin->name,
                "role"=> "admin"
            ], $JWT_SECRET, $JWT_ALGORITHM);
            $admin->token = $token;
            $admin->save();
            return new AdminResource($admin);
        } catch (\Throwable $err) {
            $this->throwResponse($err->getMessage(), 500, "INTERNAL_SERVER_ERROR", [
                "error_detail" => $err
            ]);
        }
    }

    function logout(string $id): bool
    {
        try {
        Admin::query()->where("id", $id)->update(['token' => null]);
        return  true;
        } catch (\Throwable $err){
            $this->throwResponse($err->getMessage(), 500, "INTERNAL_SERVER_ERROR", [
                "error_detail" => $err
            ]);
        }
    }


}
