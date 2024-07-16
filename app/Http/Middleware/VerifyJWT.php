<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyJWT
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $JWT_SECRET = env("JWT_SECRET");
        $JWT_ALGORITHM = env('JWT_ALGORITHM');
        $token = $request->bearerToken();

        if (!$token) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "messages" => [
                        "unauthorized"
                    ]
                ]
            ], 401));
        }

        try {
            $decoded = JWT::decode($token, new Key($JWT_SECRET, $JWT_ALGORITHM));
        } catch (\Throwable $err) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "messages" => [
                        "unauthorized"
                    ]
                ]
            ], 401));
        }

        try {
            $admin = Admin::query()->where("username", $decoded->username)->first();
            Log::info(json_encode($decoded));
            if (!$admin || $token !== $admin->token) {
               return (response()->json([
                    "errors" => [
                        "messages" => [
                            "session expired"
                        ]
                    ]
                ], 401));
            }

            $request->merge(["decodedData" => [
                "admin" => [
                    "id" => $decoded->id,
                    "username" => $decoded->username,
                    "name" => $decoded->name,
                    "role" => $decoded->role
                ]
            ]]);

            return $next($request);
        } catch (\Throwable $err) {
            throw new HttpResponseException(response()->json([
                "errors" => [
                    "message" => [
                        $err->getMessage(),
                    ]
                ]
            ], 500));
        }
    }
}

