<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $decodedData = $request->decodedData["admin"];
        if($decodedData["role"] === "admin"){
        return $next($request);
        } else {
            return  response()->json([
                "code"=> 401,
                "status" => "UNAUTHORIZED",
                "errors" =>[
                    "messages"=>[
                        "no access"
                    ]
                ]
            ], 401);
        }
    }
}
