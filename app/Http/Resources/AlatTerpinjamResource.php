<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlatTerpinjamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "alat_lab_id" => $this->alat_lab_id,
            "alat_lab"=>new AlatLabResource($this->whenLoaded('alat_lab')),
            "tanggal_terpinjam" => $this->tanggal_terpinjam,
            "tanggal_kembali" => $this->tanggal_kembali,
        ];
    }
}
