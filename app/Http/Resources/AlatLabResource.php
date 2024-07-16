<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlatLabResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
          "rfid_uid" => $this->rfid_uid,
             "name"=>$this->name,
            "isNeedPermission"=>$this->isNeedPermission
        ];
    }
}
