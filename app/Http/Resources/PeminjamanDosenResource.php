<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeminjamanDosenResource extends JsonResource
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
            "alat_lab" => new AlatLabResource($this->whenLoaded("alat_lab")),
            "peminjam" => new DosenResource($this->whenLoaded("dosen")),
            'keperluan' => $this->keperluan,
            'tempat_pemakaian' => $this->tempat_pemakaian,
            'tanggal_peminjaman' => $this->tanggal_peminjaman,
            'tanggal_pengembalian' => $this->tanggal_pengembalian,
            'accepted' => $this->accepted,
            "sudah_dikembalikan" => $this->sudah_dikembalikan
        ];
    }
}
