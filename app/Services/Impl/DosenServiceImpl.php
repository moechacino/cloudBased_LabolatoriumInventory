<?php

namespace App\Services\Impl;

use App\Http\Requests\DosenCreateRequest;
use App\Http\Resources\DosenResource;
use App\Models\Dosen;
use App\Services\DosenService;
use App\Traits\ApiResponder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DosenServiceImpl implements DosenService
{
    use ApiResponder;
    function create(DosenCreateRequest $request): DosenResource
    {
        $data = $request->validated();
        $isExist = Dosen::query()->where("rfid_uid", $data["rfid_uid"])->orWhere("nidn", $data["nidn"])->first();
        if ($isExist) {
            $this->throwResponse("already exist", 409, "CONFLICT");
        }

        $dosen = new Dosen($data);
        $dosen->save();

        return new DosenResource($dosen);
    }

    function getOneByRfid(string $rfid_uid): DosenResource
    {
        $dosen = Dosen::query()->where("rfid_uid", $rfid_uid)->first();
        if (!$dosen) {
            $this->throwResponse("Dosen with rfid tag {$rfid_uid} not found.", 404, "NOT_FOUND");
        }

        return new DosenResource($dosen);
    }

    function getOneById(int $id): DosenResource
    {
        $dosen = Dosen::query()->find($id);
        if (!$dosen) {
            $this->throwResponse("Dosen not found.", 404, "NOT_FOUND");
        }

        return new DosenResource($dosen);
    }

    function getAll(int $take, string $sort, string $search): array
    {
        $query = Dosen::query();

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

        $dosens = $query->paginate($take);

        return [
            "data" => DosenResource::collection($dosens),
            "page" => [
                "current" => $dosens->currentPage(),
                "total" => $dosens->lastPage(),
                "per_page" => $dosens->perPage(),
                "total_items" => $dosens->total(),
            ]
        ];
    }

    function delete(int $id): true
    {
        try {
            $dosen = Dosen::query()->findOrFail($id);
            $dosen->delete();
        } catch (ModelNotFoundException $e) {
            $this->throwResponse("Dosen not found.", 404, "NOT_FOUND");
        }
        return true;
    }

    function edit(DosenCreateRequest $request, int $id): DosenResource
    {
        $data = $request->validated();

        $dosen = Dosen::query()->find($id);
        if (!$dosen) {
            $this->throwResponse("Dosen not found.", 404, "NOT_FOUND");
        }

        if ($data["rfid_uid"] !== $dosen->rfid_uid) {
            $isExist = Dosen::query()->where("rfid_uid", $data["rfid_uid"])->first();
            if ($isExist) {
                $this->throwResponse("Dosen with rfid tag {$isExist["rfid_uid"]} already exist.", 409, "CONFLICT");
            }
        }
        $dosen->update($data);
        return new DosenResource($dosen);
    }
}
