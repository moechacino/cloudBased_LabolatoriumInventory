<?php

namespace App\Services\Impl;

use App\Http\Requests\MahasiswaCreateRequest;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use App\Services\MahasiswaService;
use App\Traits\ApiResponder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MahasiswaServiceImpl implements MahasiswaService
{
    use ApiResponder;

    function create(MahasiswaCreateRequest $request): MahasiswaResource
    {
        $data = $request->validated();
        $isExist = Mahasiswa::query()->where("rfid_uid", $data["rfid_uid"])->orWhere("nrp", $data["nrp"])->first();
        if ($isExist) {
            $this->throwResponse("already exist", 409, "CONFLICT");
        }

        $mahasiswa = new Mahasiswa($data);
        $mahasiswa->save();

        return new MahasiswaResource($mahasiswa);
    }

    function getOneByRfid(string $rfid_uid): MahasiswaResource
    {

        $mahasiswa = Mahasiswa::query()->where("rfid_uid", $rfid_uid)->first();
        if (!$mahasiswa) {
            $this->throwResponse("Mahasiswa with rfid tag {$rfid_uid} not found.", 404, "NOT_FOUND");
        }

        return new MahasiswaResource($mahasiswa);
    }

    public function getOneById(int $id): MahasiswaResource
    {
        $mahasiswa = Mahasiswa::query()->find($id);
        if (!$mahasiswa) {
            $this->throwResponse("Mahasiswa not found.", 404, "NOT_FOUND");
        }

        return new MahasiswaResource($mahasiswa);
    }

    function getAll(int $take, string $sort, string $search): array
    {
        $query = Mahasiswa::query();

        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'recent') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'recent_update') {
            $query->orderBy('updated_at', 'desc');
        }

        if (!empty($search)) {
            $query->where("name", 'LIKE', "%{$search}%");
        }

        $mahasiswas = $query->paginate($take);

        return [
            "data" => MahasiswaResource::collection($mahasiswas),
            "page" => [
                "current" => $mahasiswas->currentPage(),
                "total" => $mahasiswas->lastPage(),
                "per_page" => $mahasiswas->perPage(),
                "total_items" => $mahasiswas->total(),
            ]
        ];
    }

    function delete(int $id): true
    {
        try {
            $mahasiswa = Mahasiswa::query()->findOrFail($id);
            $mahasiswa->delete();
        } catch (ModelNotFoundException $e) {
            $this->throwResponse("Mahasiswa not found.", 404, "NOT_FOUND");
        }
        return true;
    }

    function edit(MahasiswaCreateRequest $request, int $id): MahasiswaResource
    {
        $data = $request->validated();

        $mahasiswa = Mahasiswa::query()->find($id);
        if (!$mahasiswa) {
            $this->throwResponse("Mahasiswa not found.", 404, "NOT_FOUND");
        }

        if ($data["rfid_uid"] !== $mahasiswa->rfid_uid) {
            $isExist = Mahasiswa::query()->where("rfid_uid", $data["rfid_uid"])->first();
            if ($isExist) {
                $this->throwResponse("Mahasiswa with rfid tag {$isExist["rfid_uid"]} already exist.", 409, "CONFLICT");
            }
        }
        $mahasiswa->update($data);
        return new MahasiswaResource($mahasiswa);
    }
}
