<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

trait ApiResponder
{
    public function successResponse($data, int $code, string $status, array $additionalData = []): JsonResponse
    {
        $response = [
            "code" => $code,
            "status" => $status,
            "success" => true,
            "data" => $data
        ];

        if (!empty($additionalData)) {
            $response = array_merge($response, $additionalData);
        }

        return response()->json($response, $code)->header('Content-Type', 'application/json');
    }

    public function errorResponse($err_message, int $code, string $status, array $additionalData = []): JsonResponse
    {
        $response = [
            "code" => $code,
            "status" => $status,
            "success" => false,
            "errors" => [
                "messages"=>[
                    $err_message
                ]
            ]
        ];

        if (!empty($additionalData)) {
            $response = array_merge($response, $additionalData);
        }

        return response()->json($response, $code)->header('Content-Type', 'application/json');
    }

    public function throwResponse($err_message, int $code, string $status, array $additionalData = []) : void
    {
        $response = [
            "code" => $code,
            "status" => $status,
            "success" => false,
            "errors" => [
                "message" => [
                    $err_message
                ]
            ]
        ];

        if (!empty($additionalData)) {
            $response = array_merge($response, $additionalData);
        }
        throw new HttpResponseException(response()->json($response, $code)->header('Content-Type', 'application/json'));
    }
}

