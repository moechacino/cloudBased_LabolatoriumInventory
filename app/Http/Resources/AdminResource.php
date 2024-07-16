<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

//    public function __construct($resource, $statusCode = 200)
//    {
//        parent::__construct($resource);
//        $this->statuseCode = $statusCode;
//    }
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=>$this->name,
            "username"=>$this->username,
            "token"=>$this->token
        ];
    }

//    public function toResponse( $request)
//    {
//        return (new ResourceResponse($this))->toResponse($request)->setStatusCode($this->statuseCode);
//    }
}
